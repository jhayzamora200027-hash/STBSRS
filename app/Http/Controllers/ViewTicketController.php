<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketComment;
use App\Models\TicketCommentAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketAcknowledgedMail;

class ViewTicketController extends Controller
{
    public function index(string $ticket_id){
            $ticket = Ticket::with([
                'programDetails',
                'requestRegion',
                'requestForRegion',
                'requestProvince',
                'requestCity',
                'agency'
                ])->where('ticket_id', $ticket_id)->firstOrFail();

            $latestResolution = $ticket->resolutions()
                ->with('attachments')
                ->latest()
                ->first();

            $activities = $ticket->activities()->get();

            return view('authpage.tickets.viewticket', compact('ticket', 'latestResolution', 'activities'));
    }

    public function delete(string $ticket_id){
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstorFail();

        $ticket->delete();
    return redirect()->route('tickets')->with('success', 'Ticket #'. $ticket->ticket_id .' deleted successfully') ;
    }

    public function storeComment(Request $request, $ticket)
    {
        $data = $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'nullable|integer',
            'attachments.*' => 'file|max:10240'
        ]);

        $ticketModel = Ticket::where('id', $ticket)->firstOrFail();

        $comment = TicketComment::create([
            'ticket_id' => $ticketModel->id,
            'user_id' => Auth::id(),
            'guest_name' => null,
            'guest_email' => null,
            'comment' => $data['comment'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
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
        }

        $ticketModel->activities()->create([
            'event' => $data['parent_id'] ? 'comment_reply' : 'comment_added',
            'title' => $data['parent_id'] ? 'Replied to a comment' : 'Added a comment',
            'description' => $data['parent_id'] ? 'A reply was added to the discussion.' : 'A new comment was added to the discussion.',
            'performed_by' => Auth::user()?->name ?? $comment->guest_name,
        ]);

        // Load attachments for response
        $comment->load('attachments');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id' => $comment->id,
                'user_name' => Auth::user() ? Auth::user()->name : null,
                'guest_name' => $comment->guest_name,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->diffForHumans(),
                'attachments' => $comment->attachments->map(function($a){
                    return [
                        'url' => Storage::url($a->file_path),
                        'original_name' => $a->original_name,
                    ];
                })->toArray(),
            ]);
        }

        return redirect()->back()->with('success', 'Comment posted');
    }

    public function recordPrint(string $ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->activities()->create([
            'event' => 'document_printed',
            'title' => 'Document printed',
            'description' => 'The ticket request form was opened for printing.',
            'performed_by' => Auth::user()?->name,
        ]);

        return response()->noContent();
    }

    public function printPreview(string $ticket_id)
    {
        $ticket = Ticket::with([
            'programDetails',
            'requestRegion',
            'requestForRegion',
            'requestProvince',
            'requestCity'
        ])->where('ticket_id', $ticket_id)->firstOrFail();

        $latestResolution = $ticket->resolutions()
            ->with('attachments')
            ->latest()
            ->first();

        $activities = $ticket->activities()->get();

        // Render the same view; Browsershot will load this route to produce PDF.
        return view('authpage.tickets.viewticket', compact('ticket', 'latestResolution', 'activities'));
    }

    public function acknowledge(Request $request, string $ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->update([
            'ticket_status' => 'inprogress',
            'acknowledged' => true,
            'ticket_acknowledged_at' => now()
        ]);

        $ticket->activities()->create([
            'event' => 'status_changed',
            'title' => 'Ticket acknowledged',
            'description' => 'Ticket acknowledged and assigned to team.',
            'performed_by' => Auth::user()?->name,
        ]);

        // Send notification to requester if email exists
        if (!empty($ticket->requestor_email)) {
            try {
                Mail::to($ticket->requestor_email)->send(new TicketAcknowledgedMail($ticket));
            } catch (\Exception $e) {
                // Log but continue
                //
            }
        }

        return redirect()->back()->with('success', 'Ticket acknowledged and requester notified.');
    }
}
