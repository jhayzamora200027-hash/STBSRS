@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')
@php
    $eventLabels = [
        'ticket_created' => 'Ticket created',
        'created' => 'Added',
        'updated' => 'Changed',
        'deleted' => 'Removed',
        'login' => 'Signed in',
        'logout' => 'Signed out',
        'login_failed' => 'Sign-in failed',
    ];

    $recordLabels = [
        'Ticket' => 'Service request',
        'TicketActivity' => 'Request activity',
        'TicketAttachment' => 'Request attachment',
        'TicketComment' => 'Request comment',
        'TicketCommentAttachment' => 'Comment attachment',
        'TicketFeedback' => 'Request feedback',
        'TicketReturn' => 'Returned request',
        'Resolution' => 'Resolution',
        'ResolutionAttachment' => 'Resolution attachment',
        'User' => 'User account',
        'Program' => 'Program',
        'Agency' => 'Agency',
        'Region' => 'Region',
        'Province' => 'Province',
        'City' => 'City',
    ];

    $fieldLabels = [
        'ticket_status' => 'request status',
        'ticket_priority' => 'priority',
        'approved_at' => 'approval',
        'approved_by' => 'approver',
        'usergroup' => 'user role',
        'email' => 'email address',
        'status' => 'account status',
        'password' => 'password',
    ];

    $readableValue = static function ($value): string {
        if ($value === null || $value === '') {
            return 'blank';
        }

        if (is_array($value)) {
            return implode(', ', array_map(static fn ($item) => is_scalar($item) ? (string) $item : 'details', $value));
        }

        return str_replace('_', ' ', ucfirst((string) $value));
    };

    $recordName = static function ($log) use ($recordLabels): string {
        $shortName = $log->auditable_type ? class_basename($log->auditable_type) : null;
        $label = $recordLabels[$shortName] ?? ($shortName ? preg_replace('/(?<!^)([A-Z])/', ' $1', $shortName) : 'System activity');

        return $log->auditable_id ? $label . ' #' . $log->auditable_id : $label;
    };

    $changeSummary = static function ($log) use ($fieldLabels, $readableValue): string {
        $shortName = $log->auditable_type ? class_basename($log->auditable_type) : null;
        $values = $log->new_values ?? $log->old_values ?? [];

        if ($log->event === 'login') {
            return 'The user signed in to the system.';
        }

        if ($log->event === 'logout') {
            return 'The user signed out of the system.';
        }

        if ($log->event === 'login_failed') {
            return 'A sign-in attempt was unsuccessful.';
        }

        if ($log->event === 'created') {
            if ($shortName === 'Ticket') {
                $requestor = trim(($values['requestor_first_name'] ?? '') . ' ' . ($values['requestor_last_name'] ?? ''));
                $category = $readableValue($values['ticket_category'] ?? null);

                return 'A new service request was submitted' . ($requestor ? ' by ' . $requestor : '') . ($category !== 'blank' ? ' for ' . $category : '') . '.';
            }

            if ($shortName === 'TicketActivity') {
                return $values['description'] ?? $values['title'] ?? 'Activity was recorded for the request.';
            }

            if ($shortName === 'TicketAttachment' || $shortName === 'ResolutionAttachment' || $shortName === 'TicketCommentAttachment') {
                $fileName = $values['attachment'] ?? $values['original_name'] ?? $values['file_name'] ?? 'a file';

                return 'The file "' . $fileName . '" was added.';
            }

            if ($shortName === 'TicketComment') {
                $comment = trim((string) ($values['comment'] ?? ''));

                return $comment ? 'A comment was added: "' . \Illuminate\Support\Str::limit($comment, 160) . '"' : 'A comment was added to the request.';
            }

            if ($shortName === 'Resolution') {
                $resolution = trim((string) ($values['resolution_text'] ?? ''));

                return $resolution ? 'A resolution was recorded: "' . \Illuminate\Support\Str::limit($resolution, 160) . '"' : 'A resolution was recorded for the request.';
            }

            if ($shortName === 'User') {
                $name = $values['name'] ?? trim(($values['first_name'] ?? '') . ' ' . ($values['last_name'] ?? ''));

                return 'A user account was created' . ($name ? ' for ' . $name : '') . '.';
            }

            if ($shortName === 'TicketFeedback') {
                return 'Feedback was submitted for the request.';
            }

            if ($shortName === 'TicketReturn') {
                return 'The requester returned the request for follow-up.';
            }

            if ($shortName === 'Program') {
                return 'The program "' . ($values['program'] ?? 'Unnamed program') . '" was added.';
            }

            return 'A new record was added.';
        }

        if ($log->event === 'deleted') {
            if ($shortName === 'Ticket') {
                return 'The service request was permanently removed.';
            }

            if ($shortName === 'User') {
                return 'The user account was permanently removed.';
            }

            return 'This record was removed.';
        }

        if (array_key_exists('ticket_status', $log->new_values ?? [])) {
            $oldStatus = $readableValue($log->old_values['ticket_status'] ?? null);
            $newStatus = $readableValue($log->new_values['ticket_status']);

            return 'Request status changed from "' . $oldStatus . '" to "' . $newStatus . '".';
        }

        $changes = collect($log->new_values ?? [])
            ->keys()
            ->reject(fn ($field) => in_array($field, ['id', 'created_at', 'updated_at'], true))
            ->map(function ($field) use ($log, $fieldLabels, $readableValue) {
                $label = $fieldLabels[$field] ?? str_replace('_', ' ', $field);
                $old = $readableValue($log->old_values[$field] ?? null);
                $new = $readableValue($log->new_values[$field] ?? null);

                return ucfirst($label) . ' changed from "' . $old . '" to "' . $new . '".';
            });

        return $changes->implode(' ') ?: 'The record was updated.';
    };
@endphp
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <div class="text-uppercase small fw-semibold text-muted">Sysadmin controls</div>
            <h1 class="h3 mb-1">Audit log</h1>
            <p class="text-muted mb-0">Review important activity across the system.</p>
        </div>
        <span class="badge text-bg-light border">{{ $logs->total() }} events</span>
    </div>

    <form class="row g-2 mb-3" method="GET" action="{{ route('audit-logs.index') }}">
        <div class="col-md-6">
            <label class="visually-hidden" for="audit-search">Search audit log</label>
            <input id="audit-search" name="search" value="{{ $filters['search'] }}" class="form-control" placeholder="Search activity or person">
        </div>
        <div class="col-md-3">
            <label class="visually-hidden" for="audit-event">Filter by event</label>
            <select id="audit-event" name="event" class="form-select">
                <option value="">All events</option>
                @foreach($eventOptions as $eventValue => $eventLabel)
                    <option value="{{ $eventValue }}" @selected($filters['event'] === $eventValue)>{{ $eventLabel }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel me-1"></i>Filter</button></div>
        <div class="col-md-1"><a class="btn btn-light border w-100" href="{{ route('audit-logs.index') }}" title="Clear filters"><i class="bi bi-x-lg"></i></a></div>
    </form>

    <div class="table-responsive bg-white border rounded-3">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Date and time</th><th>Action</th><th>Ticket number</th><th>What was affected</th><th>Performed by</th><th>Details</th></tr></thead>
            <tbody>
            @forelse($logs as $log)
                <tr>
                    <td class="text-nowrap">{{ $log->created_at->format('M d, Y g:i A') }}</td>
                    <td><span class="badge text-bg-secondary">{{ $log->event === 'created' && $log->auditable_type === 'App\\Models\\Ticket' ? $eventLabels['ticket_created'] : ($eventLabels[$log->event] ?? ucfirst(str_replace('_', ' ', $log->event))) }}</span></td>
                    <td>{{ $log->ticket_number ?? '-' }}</td>
                    <td>{{ $recordName($log) }}</td>
                    <td>
                        @if($log->user)
                            {{ $log->user->name }}
                        @elseif($log->event === 'created' && $log->auditable_type === 'App\\Models\\Ticket')
                            Guest requester
                        @else
                            System activity
                        @endif
                    </td>
                    <td>
                        <details>
                            <summary class="text-primary">View activity</summary>
                            <p class="small mb-1 mt-2">{{ $changeSummary($log) }}</p>
                            @if($log->ip_address)
                                <small class="text-muted">Accessed from {{ $log->ip_address }}</small>
                            @endif
                        </details>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">No activity found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $logs->links() }}</div>
</div>
@endsection