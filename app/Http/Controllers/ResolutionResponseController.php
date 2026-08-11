<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Resolution;
use Illuminate\Http\Request;

class ResolutionResponseController extends Controller
{
    public function confirm(Request $request, $ticket_id, $resolution_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $resolution = Resolution::findOrFail($resolution_id);

        $ticket->update([
            'ticket_status' => 'completed',
            'ticket_resolved_at' => null,
        ]);
        $ticket->activities()->create([
            'event' => 'status_changed',
            'title' => 'Status changed to Completed',
            'description' => 'The resolution was confirmed and the ticket was completed.',
            'performed_by' => 'Requester',
        ]);

        return view('tickets.resolution_response', [
            'message' => 'Thank you. The ticket has been marked as solved (completed).',
            'ticket' => $ticket,
        ]);
    }

    public function returned(Request $request, $ticket_id, $resolution_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $resolution = Resolution::findOrFail($resolution_id);

        $ticket->update([
            'ticket_status' => 'inprogress',
            'ticket_resolved_at' => null,
        ]);
        $ticket->activities()->create([
            'event' => 'status_changed',
            'title' => 'Ticket returned for follow-up',
            'description' => 'The requester returned the ticket and its status changed to In Progress.',
            'performed_by' => 'Requester',
        ]);

        return view('tickets.resolution_response', [
            'message' => 'The ticket has been returned to the team. Thank you for the update.',
            'ticket' => $ticket,
        ]);
    }
}
