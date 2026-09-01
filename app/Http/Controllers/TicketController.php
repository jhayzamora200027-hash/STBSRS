<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use App\Models\TicketCommentAttachment;
use App\Models\TicketReturn;
use App\Models\User;
use App\Mail\TicketReturnedMail;
use App\Mail\TicketCommentMail;
use App\Mail\TicketCompletedMail;
use App\Mail\NewTicketAdminMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
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
            'received_ticket_to' => 'required|in:CO,FO',
            'received_ticket_to_office' => 'nullable',
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

        if ($request->input('ticket_category') === 'resource' || $request->has('title_of_activity')) {
            $rules['title_of_activity'] = 'required|string|max:255';
            $rules['target_participants'] = 'required|string|max:255';
            $rules['venue'] = 'nullable|string|max:255';
            $rules['type_of_activity'] = 'required|string|max:255';
            $rules['date_of_activity'] = 'required|date';
            $rules['date_of_activity_end'] = 'required|date|after_or_equal:date_of_activity';
        }

        if ($request->has('type_of_knowledge_product')) {
            $rules['type_of_knowledge_product'] = 'required|array|min:1';
            $rules['type_of_knowledge_product.*'] = 'string|max:255';
        }

        if ($request->input('received_ticket_to') === 'FO') {
            $rules['received_ticket_to_office'] = 'required|string|max:255';
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
                'received_ticket_to' => $request->received_ticket_to,
                'received_ticket_to_office' => $request->received_ticket_to === 'FO'
                    ? $request->received_ticket_to_office
                    : null,

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

                'title_of_activity' => $request->title_of_activity,
                'target_participants' => $request->target_participants,

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
                $ticketUrl = URL::temporarySignedRoute(
                    'ticket.email.redirect',
                    now()->addMinutes(30),
                    ['ticket_id' => $ticket->ticket_id]
                );

                Mail::send('emails.ticket_submitted', ['ticket' => $ticket, 'ticketUrl' => $ticketUrl], function ($m) use ($ticket) {
                    $m->to($ticket->requestor_email)->subject('iSTaksyon - Request Submitted: ' . $ticket->ticket_id);
                    if (config('mail.from.address')) {
                        $m->from(config('mail.from.address'), config('mail.from.name'));
                    }
                });
            } catch (\Exception $e) {
                Log::warning('Failed to send ticket confirmation email', ['error' => $e->getMessage()]);
            }

            $sysadminEmails = User::query()
                ->whereNotNull('email')
                ->whereRaw('LOWER(usergroup) = ?', ['sysadmin'])
                ->pluck('email')
                ->filter()
                ->unique()
                ->values();

            foreach ($sysadminEmails as $sysadminEmail) {
                try {
                    Mail::to($sysadminEmail)->send(new NewTicketAdminMail($ticket));
                } catch (\Throwable $exception) {
                    Log::error('Failed to send new ticket notification to sysadmin.', [
                        'ticket_id' => $ticket->ticket_id,
                        'recipient' => $sysadminEmail,
                        'error' => $exception->getMessage(),
                    ]);
                }
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
            'received_ticket_to' => 'required|in:CO,FO',
            'received_ticket_to_office' => 'nullable',
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

        if ($request->input('ticket_category') === 'resource' || $request->has('title_of_activity')) {
            $rules['title_of_activity'] = 'required|string|max:255';
            $rules['target_participants'] = 'required|string|max:255';
            $rules['venue'] = 'nullable|string|max:255';
            $rules['type_of_activity'] = 'required|string|max:255';
            $rules['date_of_activity'] = 'required|date';
            $rules['date_of_activity_end'] = 'required|date|after_or_equal:date_of_activity';
        }

        if ($request->has('type_of_knowledge_product')) {
            $rules['type_of_knowledge_product'] = 'required|array|min:1';
            $rules['type_of_knowledge_product.*'] = 'string|max:255';
        }

        if ($request->input('received_ticket_to') === 'FO') {
            $rules['received_ticket_to_office'] = 'required|string|max:255';
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
                'received_ticket_to' => $request->received_ticket_to,
                'received_ticket_to_office' => $request->received_ticket_to === 'FO'
                    ? $request->received_ticket_to_office
                    : null,

                'ticket_category' => $request->ticket_category,

                'purpose_of_request' => $request->purpose_of_request,

                'program' => is_array($request->program) ? json_encode($request->program) : $request->program,

                'program_others' => $request->program_others,

                'type_of_knowledge_product' => is_array($request->type_of_knowledge_product) ? json_encode($request->type_of_knowledge_product) : $request->type_of_knowledge_product,

                'type_of_knowledge_product_others' => $request->type_of_knowledge_product_others,

                'title_of_activity' => $request->title_of_activity,
                'target_participants' => $request->target_participants,

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
        Log::info('verifyOtp called', ['email' => $request->email ?? null, 'ip' => $request->ip()]);
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

    /**
     * Send OTP to the requestor email associated with a ticket reference.
     */
    public function sendOtpForTicket(Request $request)
    {
        Log::info('sendOtpForTicket called', ['ticket_id' => $request->ticket_id, 'ip' => $request->ip()]);
        $request->validate([
            'ticket_id' => 'required|string'
        ]);

        $ticket = Ticket::where('ticket_id', $request->ticket_id)->first();
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found.'], 404);
        }

        if (empty($ticket->requestor_email)) {
            return response()->json(['message' => 'No email associated with this ticket.'], 422);
        }

        $email = $ticket->requestor_email;

        // if this ticket was already OTP-verified recently, skip sending a new code
        $alreadyVerified = Session::get('ticket_otp_verified', false);
        $verifiedTicket = Session::get('ticket_otp_ticket');
        $verifiedAt = Session::get('ticket_otp_verified_at');

        if ($alreadyVerified && $verifiedTicket === $ticket->ticket_id && $verifiedAt
            && Carbon::parse($verifiedAt)->addMinutes(30)->gte(Carbon::now())) {
            return response()->json([
                'already_verified' => true,
                'message' => 'Already verified.',
                'redirect' => route('guest.ticket.view', $ticket->ticket_id),
            ]);
        }

        // reuse session structure used by sendOtp
        Session::forget(['ticket_otp_verified', 'ticket_otp_email']);

        $otp = random_int(100000, 999999);
        $expires = Carbon::now()->addMinutes(10);

        Session::put('ticket_otp', [
            'email' => $email,
            'otp' => (string)$otp,
            'expires_at' => $expires->toDateTimeString(),
            'ticket_id' => $ticket->ticket_id,
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
            Log::error('Failed to send OTP email for ticket', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Failed to send OTP.'], 500);
        }

        [$localPart, $domain] = array_pad(explode('@', $email, 2), 2, '');
        $visibleCharacters = min(2, strlen($localPart));
        $maskedEmail = substr($localPart, 0, $visibleCharacters)
            . str_repeat('*', max(0, strlen($localPart) - $visibleCharacters));

        if ($domain !== '') {
            $maskedEmail .= '@' . $domain;
        }

        return response()->json([
            'message' => 'OTP sent to the ticket requestor.',
            'masked_email' => $maskedEmail,
        ]);
    }

    /**
     * Verify OTP for a ticket flow.
     */
    public function verifyOtpForTicket(Request $request)
    {
        Log::info('verifyOtpForTicket called', ['ticket_id' => $request->ticket_id, 'ip' => $request->ip()]);
        $request->validate([
            'ticket_id' => 'required|string',
            'otp' => 'required'
        ]);

        $payload = Session::get('ticket_otp');
        if (!$payload) {
            return response()->json(['message' => 'No OTP found. Please request a new code.'], 422);
        }

        if (($payload['ticket_id'] ?? null) !== $request->ticket_id) {
            return response()->json(['message' => 'OTP does not match this ticket.'], 422);
        }

        if (Carbon::now()->gt(Carbon::parse($payload['expires_at']))) {
            return response()->json(['message' => 'OTP expired. Please request a new code.'], 422);
        }

        if ((string)$payload['otp'] !== (string)$request->otp) {
            return response()->json(['message' => 'Invalid OTP code.'], 422);
        }

        // mark verified and associate with ticket
        Session::put('ticket_otp_verified', true);
        Session::put('ticket_otp_email', $payload['email']);
        Session::put('ticket_otp_ticket', $payload['ticket_id']);
        // record verification timestamp so we can expire the authorization after a short window
        Session::put('ticket_otp_verified_at', Carbon::now()->toDateTimeString());

        return response()->json(['message' => 'Ticket verified.']);
    }

    /**
     * Send OTP to a requestor email so they can look up all tickets tied to it.
     */
    public function sendOtpForEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        if (!Ticket::where('requestor_email', $email)->exists()) {
            return response()->json(['message' => 'No requests found for this email address.'], 404);
        }

        // if this email was already OTP-verified recently, skip sending a new code
        $alreadyVerified = Session::get('guest_email_otp_verified', false);
        $verifiedEmail = Session::get('guest_email_otp_email');
        $verifiedAt = Session::get('guest_email_otp_verified_at');

        if ($alreadyVerified && $verifiedEmail === $email && $verifiedAt
            && Carbon::parse($verifiedAt)->addMinutes(30)->gte(Carbon::now())) {
            return response()->json([
                'already_verified' => true,
                'message' => 'Already verified.',
                'redirect' => route('guest.tickets.list'),
            ]);
        }

        Session::forget(['guest_email_otp', 'guest_email_otp_verified', 'guest_email_otp_email', 'guest_email_otp_verified_at']);

        $otp = random_int(100000, 999999);
        $expires = Carbon::now()->addMinutes(10);

        Session::put('guest_email_otp', [
            'email' => $email,
            'otp' => (string)$otp,
            'expires_at' => $expires->toDateTimeString(),
        ]);

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
            Log::error('Failed to send OTP email for guest email lookup', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Failed to send OTP.'], 500);
        }

        [$localPart, $domain] = array_pad(explode('@', $email, 2), 2, '');
        $visibleCharacters = min(2, strlen($localPart));
        $maskedEmail = substr($localPart, 0, $visibleCharacters)
            . str_repeat('*', max(0, strlen($localPart) - $visibleCharacters));

        if ($domain !== '') {
            $maskedEmail .= '@' . $domain;
        }

        return response()->json([
            'message' => 'OTP sent to ' . $maskedEmail,
            'masked_email' => $maskedEmail,
        ]);
    }

    /**
     * Verify OTP for the guest email lookup flow.
     */
    public function verifyOtpForEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $payload = Session::get('guest_email_otp');
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

        Session::put('guest_email_otp_verified', true);
        Session::put('guest_email_otp_email', $request->email);
        Session::put('guest_email_otp_verified_at', Carbon::now()->toDateTimeString());

        return response()->json(['message' => 'Email verified.']);
    }

    /**
     * List tickets tied to the OTP-verified email address.
     */
    public function guestListByEmail()
    {
        $verified = Session::get('guest_email_otp_verified', false);
        $email = Session::get('guest_email_otp_email', null);
        $verifiedAt = Session::get('guest_email_otp_verified_at', null);

        if (!$verified || !$email || !$verifiedAt) {
            return redirect()->route('home')->with('error', 'You cannot access this page.');
        }

        $expiresAfterMinutes = 30;
        $expiresAt = Carbon::parse($verifiedAt)->addMinutes($expiresAfterMinutes);
        if ($expiresAt->lt(Carbon::now())) {
            Session::forget(['guest_email_otp', 'guest_email_otp_verified', 'guest_email_otp_email', 'guest_email_otp_verified_at']);
            return redirect()->route('home')->with('error', 'You cannot access this page.');
        }

        $tickets = Ticket::where('requestor_email', $email)
            ->latest()
            ->get();

        return view()->file(resource_path('views/guestpage/guestviewpage.php/guesttickets.blade.php'), compact('tickets', 'email', 'expiresAt'));
    }

    /**
     * Show guest view for a ticket after OTP verification.
     */
    public function guestView(Request $request, string $ticket_id)
    {
        $signedUrlAuthorized = \Illuminate\Support\Facades\URL::hasValidSignature($request);

        if ($signedUrlAuthorized) {
            Session::put('ticket_otp_verified', true);
            Session::put('ticket_otp_ticket', $ticket_id);
            Session::put('ticket_otp_verified_at', Carbon::now()->toDateTimeString());
        }

        $verified = Session::get('ticket_otp_verified', false);
        $sessionTicket = Session::get('ticket_otp_ticket', null);
        $verifiedAt = Session::get('ticket_otp_verified_at', null);

        $ticketAuthorized = $signedUrlAuthorized || ($verified && $sessionTicket === $ticket_id && $verifiedAt
            && Carbon::parse($verifiedAt)->addMinutes(30)->gte(Carbon::now()));

        if (!$ticketAuthorized) {
            $emailVerified = Session::get('guest_email_otp_verified', false);
            $verifiedEmail = Session::get('guest_email_otp_email', null);
            $emailVerifiedAt = Session::get('guest_email_otp_verified_at', null);

            $emailAuthorized = $emailVerified && $verifiedEmail && $emailVerifiedAt
                && Carbon::parse($emailVerifiedAt)->addMinutes(30)->gte(Carbon::now())
                && Ticket::where('ticket_id', $ticket_id)->where('requestor_email', $verifiedEmail)->exists();

            if (!$emailAuthorized) {
                return redirect()->route('home')->with('error', 'You cannot access this page.');
            }
        }

        $ticket = Ticket::with([
            'programDetails',
            'requestRegion',
            'requestForRegion',
            'requestProvince',
            'requestCity',
            'agency',
            'comments.user',
            'comments.attachments',
            'comments.replies.user',
            'comments.replies.attachments',
            'resolutions.attachments',
            'feedback',
        ])->where('ticket_id', $ticket_id)->firstOrFail();

        // render existing guest ticket view (file is nested under guestviewpage.php folder)
        return view()->file(resource_path('views/guestpage/guestviewpage.php/guestticketview.blade.php'), compact('ticket'));
    }

    public function storeGuestComment(Request $request, string $ticket_id)
    {
        $verified = Session::get('ticket_otp_verified', false);
        $sessionTicket = Session::get('ticket_otp_ticket');
        $verifiedAt = Session::get('ticket_otp_verified_at');

        if (!$verified || $sessionTicket !== $ticket_id || !$verifiedAt || Carbon::parse($verifiedAt)->addMinutes(30)->lt(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot access this page.');
        }

        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $data = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'integer'],
            'attachments.*' => ['file', 'max:10240'],
        ]);

        $parentId = $data['parent_id'] ?? null;
        if ($parentId && !TicketComment::where('id', $parentId)->where('ticket_id', $ticket->id)->exists()) {
            abort(422, 'The selected comment is invalid.');
        }

        $comment = TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => null,
            'guest_name' => trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
            'guest_email' => Session::get('ticket_otp_email'),
            'comment' => $data['comment'],
            'parent_id' => $parentId,
        ]);

        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('ticket_comment_attachments', 'public');
            TicketCommentAttachment::create([
                'ticket_comment_id' => $comment->id,
                'original_name' => $file->getClientOriginalName(),
                'file_name' => basename($path),
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        $ticket->activities()->create([
            'event' => $parentId ? 'comment_reply' : 'comment_added',
            'title' => $parentId ? 'Guest replied to a comment' : 'Guest added a comment',
            'description' => $parentId ? 'A guest reply was added to the discussion.' : 'A guest comment was added to the discussion.',
            'performed_by' => trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
        ]);

        $recipientEmails = User::query()
            ->whereNotNull('email')
            ->whereRaw('LOWER(usergroup) IN (?, ?)', ['admin', 'sysadmin'])
            ->pluck('email')
            ->filter()
            ->unique()
            ->values();

        foreach ($recipientEmails as $recipientEmail) {
            try {
                Mail::to($recipientEmail)->send(
                    new TicketCommentMail($ticket, $comment, (bool) $parentId)
                );
            } catch (\Throwable $exception) {
                Log::error('Unable to send guest comment notification.', [
                    'ticket_id' => $ticket->ticket_id,
                    'recipient' => $recipientEmail,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return redirect()->route('guest.ticket.view', $ticket->ticket_id)->with('success', 'Comment posted.');
    }

    public function returnGuestTicket(Request $request, string $ticket_id)
    {
        $verified = Session::get('ticket_otp_verified', false);
        $sessionTicket = Session::get('ticket_otp_ticket');
        $verifiedAt = Session::get('ticket_otp_verified_at');

        if (!$verified || $sessionTicket !== $ticket_id || !$verifiedAt || Carbon::parse($verifiedAt)->addMinutes(30)->lt(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot access this page.');
        }

        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        if ($ticket->ticket_status !== 'resolved') {
            return back()->withErrors(['return_reason' => 'Only resolved tickets can be returned.']);
        }

        $data = $request->validate([
            'return_reason' => ['required', 'string', 'max:2000'],
            'urgency' => ['required', 'in:low,medium,high,urgent'],
        ]);

        $ticketReturn = TicketReturn::create([
            'ticket_id' => $ticket->id,
            'return_reason' => $data['return_reason'],
            'urgency' => $data['urgency'],
            'returned_by' => null,
            'returned_at' => now(),
        ]);

        $ticket->update([
            'ticket_status' => 'inprogress',
            'ticket_resolved_at' => null,
        ]);

        $ticket->activities()->create([
            'event' => 'ticket_returned',
            'title' => 'Ticket returned for follow-up',
            'description' => 'The requester returned the ticket for additional assistance.',
            'performed_by' => trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
        ]);

        $recipientEmails = User::query()
            ->whereNotNull('email')
            ->whereRaw('LOWER(usergroup) IN (?, ?)', ['admin', 'sysadmin'])
            ->pluck('email')
            ->filter()
            ->unique()
            ->values();

        foreach ($recipientEmails as $recipientEmail) {
            try {
                Mail::to($recipientEmail)->send(new TicketReturnedMail($ticket, $ticketReturn));
            } catch (\Throwable $exception) {
                Log::error('Unable to send ticket return notification.', [
                    'ticket_id' => $ticket->ticket_id,
                    'recipient' => $recipientEmail,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return redirect()->route('guest.ticket.view', $ticket->ticket_id)
            ->with('success', 'Your ticket has been returned to the team for follow-up.');
    }

    public function storeGuestFeedback(Request $request, string $ticket_id)
    {
        $verified = Session::get('ticket_otp_verified', false);
        $sessionTicket = Session::get('ticket_otp_ticket');
        $verifiedAt = Session::get('ticket_otp_verified_at');

        if (!$verified || $sessionTicket !== $ticket_id || !$verifiedAt || Carbon::parse($verifiedAt)->addMinutes(30)->lt(Carbon::now())) {
            return redirect()->back()->with('error', 'You cannot access this page.');
        }

        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        if (!in_array($ticket->ticket_status, ['resolved', 'completed'], true)) {
            return back()->withErrors(['feedback' => 'Feedback is available for resolved or completed tickets.']);
        }

        if ($ticket->feedback()->exists()) {
            return redirect()->route('guest.ticket.view', $ticket->ticket_id);
        }

        $data = $request->validate([
            'overall_satisfaction' => ['required', 'integer', 'between:1,5'],
            'timeliness' => ['required', 'integer', 'between:1,5'],
            'professionalism' => ['required', 'integer', 'between:1,5'],
            'quality_of_resolution' => ['required', 'integer', 'between:1,5'],
            'ease_of_process' => ['required', 'integer', 'between:1,5'],
            'communication' => ['required', 'integer', 'between:1,5'],
            'additional_comments' => ['nullable', 'string', 'max:2000'],
        ]);

        $ticket->feedback()->create($data);

        $ticket->activities()->create([
            'event' => 'feedback_submitted',
            'title' => 'Satisfaction feedback submitted',
            'description' => 'The requester submitted ticket satisfaction feedback.',
            'performed_by' => trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name),
        ]);

        return redirect()->route('guest.ticket.view', $ticket->ticket_id)
            ->with('success', 'Thank you for sharing your feedback.')
            ->with('feedback_submitted', true);
    }
    public function complete(Ticket $ticket){
        $previousStatus = $ticket->ticket_status;
        $ticket->update([
            'ticket_status' => 'completed',
            'ticket_completed_at' => now(),
        ]);

        if ($previousStatus !== 'completed' && !empty($ticket->requestor_email)) {
            try {
                Mail::to($ticket->requestor_email)->send(new TicketCompletedMail($ticket));
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        session()->flash('open_feedback', true);

        return response()->json([
            'success' => true
        ]);
    }
}