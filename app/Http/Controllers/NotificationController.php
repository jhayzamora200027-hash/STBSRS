<?php

namespace App\Http\Controllers;

use App\Models\TicketActivity;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $lastSeenId = max(0, (int) $request->query('since', 0));

        $notifications = TicketActivity::query()
            ->with('ticket:id,ticket_id')
            ->whereIn('event', [
                'ticket_created',
                'ticket_returned',
                'ticket_auto_completed',
                'comment_added',
                'comment_reply',
            ])
            ->latest()
            ->limit(20)
            ->get()
            ->map(function (TicketActivity $activity) {
                return [
                    'id' => $activity->id,
                    'title' => $activity->title,
                    'description' => $activity->description,
                    'ticket_id' => $activity->ticket?->ticket_id,
                    'url' => $activity->ticket
                        ? route('ticket.view', $activity->ticket->ticket_id)
                        : null,
                    'event' => $activity->event,
                    'created_at' => $activity->created_at?->diffForHumans(),
                ];
            });

        $unreadCount = TicketActivity::query()
            ->where('id', '>', $lastSeenId)
            ->whereIn('event', [
                'ticket_created',
                'ticket_returned',
                'ticket_auto_completed',
                'comment_added',
                'comment_reply',
            ])
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'latest_id' => $notifications->max('id') ?? $lastSeenId,
            'unread_count' => $unreadCount,
        ]);
    }
}
