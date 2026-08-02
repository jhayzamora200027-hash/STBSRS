<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [

    'ticket_id',

    'requestor_first_name',
    'requestor_middle_name',
    'requestor_last_name',
    'requestor_extension_name',

    'requestor_sex',
    'requestor_email',

    'requestor_region',
    'requestor_province',
    'requestor_city',

    'ticket_category',

    'purpose_of_request',

    'program',
    'program_others',

    'type_of_knowledge_product',
    'type_of_knowledge_product_others',

    'venue',
    'type_of_activity',
    'date_of_activity',
    'date_of_activity_end'
];
    public function programDetails(){
        return $this->belongsTo(Program::class, 'program', 'program_id');
    }
}
