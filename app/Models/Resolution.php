<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resolution extends Model
{
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    protected $fillable = [
        'ticket_id',
        'resolution_text',
        'resolved_by',
        'resolved_at',
        'resolution_status',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function attachments()
    {
        return $this->hasMany(ResolutionAttachment::class, 'resolution_id');
    }
}
