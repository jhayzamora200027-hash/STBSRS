<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketReturn extends Model
{
    protected $fillable = [
        'ticket_id',
        'return_reason',
        'urgency',
        'returned_by',
        'returned_at',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}
