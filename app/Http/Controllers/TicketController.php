<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        Log::info('TicketController@store called', [
            'hasFile' => $request->hasFile('attachment'),
            'input_keys' => array_keys($request->all()),
        ]);
        Log::info('TicketController: allFiles keys', array_keys($request->allFiles()));
        Log::info('TicketController: content-length', ['CONTENT_LENGTH' => $_SERVER['CONTENT_LENGTH'] ?? null]);


        $rules = [
            'requestor_first_name' => 'required',
            'requestor_last_name' => 'required',
            'requestor_email' => 'nullable|email',
            'requestor_email_address' => 'nullable|email',
            'requestor_position_title' => 'nullable|string|max:255',
            'ticket_category' => 'required',
            'purpose_of_request' => 'required',
            'ticket_priority' => 'nullable',
            'organization_type' => 'required',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:51200',
        ];

        // conditional rules
        if ($request->input('organization_type') === 'lgu') {
            $rules['requestor_region'] = 'required';
            $rules['requestor_province'] = 'required';
            $rules['requestor_city'] = 'required';
        } elseif ($request->input('organization_type') === 'field_office') {
            // directorate is posted as requestor_region (directorate select uses same name)
            $rules['requestor_region'] = 'required';
            $rules['requestor_office'] = 'required';
        } elseif ($request->input('organization_type') === 'offices') {
            $rules['requestor_office'] = 'required';
        } elseif (in_array($request->input('organization_type'), ['cso','ngo','po','academe'])) {
            $rules['requestor_specific_office'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Ensure at least one email field is present
        if (empty($request->input('requestor_email')) && empty($request->input('requestor_email_address'))) {
            return back()->withErrors(['requestor_email_address' => 'Email is required'])->withInput();
        }

        DB::beginTransaction();

        try {

            $ticket = Ticket::create([

                'ticket_id' => 'STBSRS-' . now()->format('YmdHis'),

                'requestor_first_name' => $request->requestor_first_name,
                'requestor_middle_name' => $request->requestor_middle_name,
                'requestor_last_name' => $request->requestor_last_name,
                'requestor_extension_name' => $request->requestor_extension_name,

                'requestor_sex' => $request->requestor_sex,
                // prefer new input name when present, fallback to legacy; write only to existing DB column
                'requestor_email' => $request->requestor_email_address ?? $request->requestor_email,
                'requestor_position_title' => $request->requestor_position_title ?? null,
                'requestor_mobile_number' => $request->requestor_mobile_number ?? null,
                'requestor_office_address' => $request->requestor_office_address ?? null,

                'requestor_region' => $request->requestor_region ?? '',
                'requestor_province' => $request->requestor_province ?? '',
                'requestor_city' => $request->requestor_city ?? '',
                // organization fields
                'requestor_organization' => $request->organization_type ?? null,
                'requestor_office' => $request->requestor_office ?? null,
                'requestor_specific_office' => $request->requestor_specific_office ?? null,

                'ticket_category' => $request->ticket_category,

                'purpose_of_request' => $request->purpose_of_request,

                'program' => is_array($request->program)
                    ? json_encode($request->program)
                    : $request->program,

                'program_others' => $request->program_others,

                'type_of_knowledge_product' => is_array($request->type_of_knowledge_product)
                    ? json_encode($request->type_of_knowledge_product)
                    : $request->type_of_knowledge_product,

                'type_of_knowledge_product_others'
                    => $request->type_of_knowledge_product_others,

                'venue' => $request->venue,

                'type_of_activity' => $request->type_of_activity,

                'date_of_activity' => $request->date_of_activity,

                'date_of_activity_end' => $request->date_of_activity_end
                ,
                'ticket_priority' => (function($val){
                    if (is_array($val)) {
                        $first = collect($val)->filter(function($v){ return $v !== null && $v !== ''; })->first();
                        return $first ?? null;
                    }
                    if ($val === '') return null;
                    return $val;
                })($request->ticket_priority)
            ]);

            // Defensive check and logging to aid debugging if ticket isn't persisted
            if (!$ticket || !$ticket->id) {
                Log::error('TicketController: Ticket::create returned null or missing id', ['ticket_object' => $ticket]);
                throw new \Exception('Failed to create ticket record');
            }

            Log::info('TicketController: ticket created', ['id' => $ticket->id, 'ticket_id' => $ticket->ticket_id]);

            $ticket->activities()->create([
                'event' => 'ticket_created',
                'title' => 'Ticket submitted',
                'description' => 'The request was submitted and is waiting for review.',
                'performed_by' => trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
            ]);



            if ($request->hasFile('attachment')) {

                Log::info('TicketController: attachment detected', [
                    'hasFile' => $request->hasFile('attachment'),
                    'files' => array_keys($request->allFiles()),
                ]);

                $file = $request->file('attachment');

                Log::info('TicketController: uploaded file info', [
                    'originalName' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                $filename = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs('ticket_attachments', $filename, 'public');

                Log::info('TicketController: stored file path', ['path' => $path]);

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'attachment' => $file->getClientOriginalName(),
                    'attachment_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);

                $ticket->activities()->create([
                    'event' => 'attachment_added',
                    'title' => 'Attachment added',
                    'description' => 'Added request attachment: ' . $file->getClientOriginalName(),
                    'performed_by' => trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
                ]);
            }

            DB::commit();

            try {
                Mail::send('emails.ticket_submitted', ['ticket' => $ticket], function ($m) use ($ticket) {
                    $m->to($ticket->requestor_email)->subject('STBSRS - Request Submitted: ' . $ticket->ticket_id);
                    if (config('mail.from.address')) {
                        $m->from(config('mail.from.address'), config('mail.from.name'));
                    }
                });
            } catch (\Exception $e) {
                Log::warning('Failed to send ticket confirmation email', ['error' => $e->getMessage()]);
            }

            Session::forget(['ticket_otp', 'ticket_otp_verified', 'ticket_otp_email']);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'title' => 'Request submitted',
                    'message' => 'Your ticket was submitted successfully.',
                    'redirect' => url('/'),
                    'ticket_number' => $ticket->ticket_id,
                    'ticket' => $ticket->toArray(),
                ]);
            }

            return redirect()
                ->back()
                ->with('success', 'Ticket submitted successfully.')
                ->with('created_ticket_number', $ticket->ticket_id);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('TicketController store error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Update existing ticket
     */
    public function update(Request $request, Ticket $ticket)
    {
        // reuse validation from store
        $rules = [
            'requestor_first_name' => 'required',
            'requestor_last_name' => 'required',
            'requestor_email' => 'required|email',
            'ticket_category' => 'required',
            'purpose_of_request' => 'required',
            'ticket_priority' => 'nullable',
            'organization_type' => 'required',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:51200',
        ];

        if ($request->input('organization_type') === 'lgu') {
            $rules['requestor_region'] = 'required';
            $rules['requestor_province'] = 'required';
            $rules['requestor_city'] = 'required';
        } elseif ($request->input('organization_type') === 'field_office') {
            $rules['requestor_region'] = 'required';
            $rules['requestor_office'] = 'required';
        } elseif ($request->input('organization_type') === 'offices') {
            $rules['requestor_office'] = 'required';
        } elseif (in_array($request->input('organization_type'), ['cso','ngo','po','academe'])) {
            $rules['requestor_specific_office'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $ticket->update([
                // do not change ticket_id
                'requestor_first_name' => $request->requestor_first_name,
                'requestor_middle_name' => $request->requestor_middle_name,
                'requestor_last_name' => $request->requestor_last_name,
                'requestor_extension_name' => $request->requestor_extension_name,

                'requestor_sex' => $request->requestor_sex,
                'requestor_email' => $request->requestor_email,

                'requestor_region' => $request->requestor_region ?? '',
                'requestor_province' => $request->requestor_province ?? '',
                'requestor_city' => $request->requestor_city ?? '',
                'requestor_organization' => $request->organization_type ?? null,
                'requestor_office' => $request->requestor_office ?? null,
                'requestor_specific_office' => $request->requestor_specific_office ?? null,

                'ticket_category' => $request->ticket_category,

                'purpose_of_request' => $request->purpose_of_request,

                'program' => is_array($request->program) ? json_encode($request->program) : $request->program,

                'program_others' => $request->program_others,

                'type_of_knowledge_product' => is_array($request->type_of_knowledge_product) ? json_encode($request->type_of_knowledge_product) : $request->type_of_knowledge_product,

                'type_of_knowledge_product_others' => $request->type_of_knowledge_product_others,

                'venue' => $request->venue,
                'type_of_activity' => $request->type_of_activity,
                'date_of_activity' => $request->date_of_activity,
                'date_of_activity_end' => $request->date_of_activity_end,
                'ticket_priority' => (function($val){
                    if (is_array($val)) {
                        $first = collect($val)->filter(function($v){ return $v !== null && $v !== ''; })->first();
                        return $first ?? null;
                    }
                    if ($val === '') return null;
                    return $val;
                })($request->ticket_priority)
            ]);

            $ticket->activities()->create([
                'event' => 'ticket_updated',
                'title' => 'Ticket details updated',
                'description' => 'The request information was updated.',
                'performed_by' => auth()->user()?->name ?? trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
            ]);

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('ticket_attachments', $filename, 'public');
                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'attachment' => $file->getClientOriginalName(),
                    'attachment_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);

                $ticket->activities()->create([
                    'event' => 'attachment_added',
                    'title' => 'Attachment added',
                    'description' => 'Added request attachment: ' . $file->getClientOriginalName(),
                    'performed_by' => auth()->user()?->name ?? trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
                ]);
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'title' => 'Request updated',
                    'message' => 'Your ticket was updated successfully.',
                    'redirect' => url('/'),
                    'ticket_number' => $ticket->ticket_id,
                    'ticket' => $ticket->toArray(),
                ]);
            }

            return redirect()
                ->back()
                ->with('success', 'Ticket updated successfully.')
                ->with('created_ticket_number', $ticket->ticket_id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('TicketController update error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors($e->getMessage());
        }
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        Session::forget(['ticket_otp_verified', 'ticket_otp_email']);

        $otp = random_int(100000, 999999);

        $expires = Carbon::now()->addMinutes(10);

        Session::put('ticket_otp', [
            'email' => $email,
            'otp' => (string)$otp,
            'expires_at' => $expires->toDateTimeString()
        ]);

            // Prepare first name fallback from email local part
            $firstName = null;
            if (strpos($email, '@') !== false) {
                $firstName = explode('@', $email)[0];
                $firstName = preg_replace('/[._\-\d]+/', ' ', $firstName);
                $firstName = trim($firstName);
                $firstName = $firstName ? ucwords($firstName) : null;
            }

            try {
                $minutes = 10;
                Mail::send('emails.otp', ['firstName' => $firstName, 'otp' => $otp, 'minutes' => $minutes], function ($m) use ($email) {
                    $m->to($email)->subject('OTP Verification');
                    if (config('mail.from.address')) {
                        $m->from(config('mail.from.address'), config('mail.from.name'));
                    }
                });
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                $payload = ['message' => 'Failed to send OTP.'];
                if (config('app.debug')) {
                    $payload['error'] = $e->getMessage();
                }
                return response()->json($payload, 500);
            }

        return response()->json(['message' => 'OTP sent to ' . $email]);
    }

    public function index(Request $request)
    {
        $tickets = Ticket::with('programDetails')
            ->latest()
            ->paginate(10);

        return view('authpage.tickets.all_tickets', compact('tickets'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $payload = Session::get('ticket_otp');
        if (!$payload) {
            return response()->json(['message' => 'No OTP found. Please request a new code.'], 422);
        }

        if ($payload['email'] !== $request->email) {
            return response()->json(['message' => 'Email mismatch for OTP.'], 422);
        }

        if (Carbon::now()->gt(Carbon::parse($payload['expires_at']))) {
            return response()->json(['message' => 'OTP expired. Please request a new code.'], 422);
        }

        if ((string)$payload['otp'] !== (string)$request->otp) {
            return response()->json(['message' => 'Invalid OTP code.'], 422);
        }

        // mark verified
        Session::put('ticket_otp_verified', true);
        Session::put('ticket_otp_email', $request->email);

        return response()->json(['message' => 'Email verified.']);
    }

    /**
     * Return current OTP status from session for client-side validation.
     */
    public function otpStatus(Request $request)
    {
        $payload = Session::get('ticket_otp', null);
        $verified = Session::get('ticket_otp_verified', false);
        $verifiedEmail = Session::get('ticket_otp_email', null);

        return response()->json([
            'exists' => $payload !== null,
            'payload' => $payload,
            'verified' => (bool)$verified,
            'verifiedEmail' => $verifiedEmail,
        ]);
    }
}