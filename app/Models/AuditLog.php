<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'event',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auditable()
    {
        return $this->morphTo();
    }

    public function getTicketNumberAttribute(): ?string
    {
        $shortName = $this->auditable_type ? class_basename($this->auditable_type) : null;
        $values = array_merge($this->old_values ?? [], $this->new_values ?? []);

        if ($shortName === 'Ticket') {
            return Ticket::query()->whereKey($this->auditable_id)->value('ticket_id')
                ?? ($values['ticket_id'] ?? null);
        }

        if (!empty($values['ticket_id'])) {
            return Ticket::query()->whereKey($values['ticket_id'])->value('ticket_id');
        }

        $ticketId = match ($shortName) {
            'ResolutionAttachment' => Resolution::query()->whereKey($values['resolution_id'] ?? null)->value('ticket_id'),
            'TicketCommentAttachment' => TicketComment::query()->whereKey($values['ticket_comment_id'] ?? null)->value('ticket_id'),
            default => null,
        };

        return $ticketId ? Ticket::query()->whereKey($ticketId)->value('ticket_id') : null;
    }
}