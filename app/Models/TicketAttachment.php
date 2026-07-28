<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'attachment',
        'attachment_path',
        'file_type',
        'file_size',
    ];
}
