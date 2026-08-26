<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()?->usergroup === 'sysadmin', 403);

        $search = trim((string) $request->input('search'));
        $event = (string) $request->input('event');

        $logs = AuditLog::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('event', 'like', "%{$search}%")
                        ->orWhere('auditable_type', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($userQuery) => $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->when($event, function ($query) use ($event) {
                if ($event === 'ticket_created') {
                    return $query->where('event', 'created')
                        ->where('auditable_type', Ticket::class);
                }

                if ($event === 'created') {
                    return $query->where('event', 'created')
                        ->where('auditable_type', '!=', Ticket::class);
                }

                return $query->where('event', $event);
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('authpage.admin.audit-logs', [
            'logs' => $logs,
            'eventOptions' => [
                'ticket_created' => 'Ticket created',
                'created' => 'Other records added',
                'updated' => 'Updated',
                'deleted' => 'Removed',
                'login' => 'Login',
                'logout' => 'Logout',
                'login_failed' => 'Failed login',
            ],
            'filters' => compact('search', 'event'),
        ]);
    }
}