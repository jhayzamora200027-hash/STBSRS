<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketFeedback extends Model
{
    protected $table = 'ticket_feedbacks';

    protected $fillable = [
        'ticket_id',
        'overall_satisfaction',
        'timeliness',
        'professionalism',
        'quality_of_resolution',
        'ease_of_process',
        'communication',
        'additional_comments',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
