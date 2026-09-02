<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class NavbarSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q', ''));

        if ($query === '' || strlen($query) < 2) {
            return response()->json(['tickets' => [], 'users' => []]);
        }

        $query = addcslashes($query, '\\%_');

        $tickets = Ticket::query()
            ->where('ticket_id', 'like', "%{$query}%")
            ->orWhere('requestor_first_name', 'like', "%{$query}%")
            ->orWhere('requestor_last_name', 'like', "%{$query}%")
            ->orWhere('requestor_email', 'like', "%{$query}%")
            ->orWhere('purpose_of_request', 'like', "%{$query}%")
            ->orderByDesc('created_at')
            ->limit(6)
            ->get([
                'ticket_id',
                'ticket_status',
                'requestor_first_name',
                'requestor_last_name',
                'purpose_of_request',
            ])
            ->map(function (Ticket $ticket) {
                return [
                    'ticket_id' => $ticket->ticket_id,
                    'status' => $ticket->ticket_status,
                    'requestor' => trim("{$ticket->requestor_first_name} {$ticket->requestor_last_name}"),
                    'purpose' => \Illuminate\Support\Str::limit($ticket->purpose_of_request, 60),
                    'url' => route('ticket.view', $ticket->ticket_id),
                ];
            });

        $users = User::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(5)
            ->get(['id', 'name', 'email', 'usergroup']);

        return response()->json([
            'tickets' => $tickets,
            'users' => $users,
        ]);
    }
}
