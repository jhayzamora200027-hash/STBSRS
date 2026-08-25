<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use App\Mail\TicketResolvedMail;
use App\Mail\TicketRejectedMail;

class ResolutionController extends Controller
{
    public function store(Request $request, string $ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $latestResolution = $ticket->resolutions()->latest()->first();
        $requestedStatus = $request->input('ticket_status');
        $requiresResolution = in_array($requestedStatus, ['resolved', 'completed', 'rejected'], true);
        $hasNewAttachments = $request->hasFile('attachments');
        $resolutionContentChanged = !$latestResolution
            || (string) ($latestResolution->resolution_text ?? '') !== (string) ($request->input('resolution_text') ?? '')
            || $hasNewAttachments;
        $createResolution = $requiresResolution && $resolutionContentChanged;

        $data = $request->validate([
            'resolution_text' => [Rule::requiredIf($requiresResolution), 'nullable', 'string'],
            'ticket_status' => ['required', 'in:review,inprogress,resolved,completed,rejected'],
            'attachments' => [
                Rule::requiredIf($createResolution && ! $latestResolution?->attachments()->exists()),
                'nullable',
                'array',
                'min:1',
            ],
            'attachments.*' => ['file', 'max:10240'],
        ]);

        if (in_array($ticket->ticket_status, ['completed', 'rejected'], true)) {
            return back()
                ->withErrors(['ticket_status' => 'This ticket is closed and can no longer be edited.'])
                ->withInput();
        }

        if ($data['ticket_status'] === 'completed' && $ticket->ticket_status !== 'resolved') {
            return back()
                ->withErrors(['ticket_status' => 'A ticket can only be marked as completed after it has been resolved.'])
                ->withInput();
        }

        $resolutionData = [
            'resolution_text' => $data['resolution_text'] ?? null,
            'resolution_status' => $data['ticket_status'],
            'resolved_by' => Auth::user()?->name,
            'resolved_at' => now(),
        ];

        $resolution = $createResolution
            ? $ticket->resolutions()->create($resolutionData)
            : $latestResolution;

        if ($resolution) {
            foreach ($request->file('attachments', []) as $file) {
                $path = $file->store('resolution-attachments/' . $ticket->ticket_id, 'public');

                $resolution->attachments()->create([
                    'attachment' => $file->getClientOriginalName(),
                    'attachment_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);

                $ticket->activities()->create([
                    'event' => 'resolution_attachment_added',
                    'title' => 'Resolution attachment added',
                    'description' => 'Added resolution attachment: ' . $file->getClientOriginalName(),
                    'performed_by' => Auth::user()?->name,
                ]);
            }
        }

        $previousStatus = $ticket->ticket_status;

        $ticketUpdate = ['ticket_status' => $data['ticket_status']];

        if ($previousStatus !== 'resolved' && $data['ticket_status'] === 'resolved') {
            $ticketUpdate['ticket_resolved_at'] = now();
        } elseif ($data['ticket_status'] !== 'resolved') {
            $ticketUpdate['ticket_resolved_at'] = null;
        }

        $ticket->update($ticketUpdate);

        $ticket->activities()->create([
            'event' => $previousStatus === $data['ticket_status'] ? 'resolution_updated' : 'status_changed',
            'title' => $previousStatus === $data['ticket_status'] ? 'Resolution updated' : 'Status changed to ' . ucfirst($data['ticket_status']),
            'description' => $previousStatus === $data['ticket_status']
                ? 'Resolution details were updated.'
                : 'Ticket status changed from ' . ucfirst($previousStatus) . ' to ' . ucfirst($data['ticket_status']) . '.',
            'performed_by' => Auth::user()?->name,
        ]);

        // If status changed to resolved, send notification to requestor with signed action links
        if (($previousStatus !== 'resolved') && $data['ticket_status'] === 'resolved') {
            try {
                $confirmUrl = URL::temporarySignedRoute(
                    'tickets.resolution.confirm', now()->addDays(7),
                    ['ticket_id' => $ticket->ticket_id, 'resolution_id' => $resolution->id]
                );

                $returnUrl = URL::temporarySignedRoute(
                    'tickets.resolution.return', now()->addDays(7),
                    ['ticket_id' => $ticket->ticket_id, 'resolution_id' => $resolution->id]
                );

                if (!empty($ticket->requestor_email)) {
                    Mail::to($ticket->requestor_email)
                        ->send(new TicketResolvedMail($ticket, $resolution, $confirmUrl, $returnUrl));
                }
            } catch (\Exception $e) {
                // swallow email exceptions for now; consider logging
            }
        }

        if ($previousStatus !== 'rejected' && $data['ticket_status'] === 'rejected') {
            try {
                if (!empty($ticket->requestor_email)) {
                    Mail::to($ticket->requestor_email)
                        ->send(new TicketRejectedMail($ticket, $resolution));
                }
            } catch (\Exception $e) {
                // swallow email exceptions for now; consider logging
            }
        }

        return back()
            ->with('success', 'Resolution saved and ticket status updated.')
            ->with('success_title', $createResolution ? 'Resolution Saved' : 'Ticket Updated');
    }
}