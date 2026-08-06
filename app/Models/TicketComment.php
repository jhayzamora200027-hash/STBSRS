<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'user_id',
        'guest_name',
        'guest_email',
        'comment',
        'parent_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(TicketComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(TicketComment::class, 'parent_id')
                    ->latest();
    }

    public function attachments()
    {
        return $this->hasMany(TicketCommentAttachment::class, 'ticket_comment_id');
    }
}