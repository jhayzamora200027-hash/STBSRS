<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;
use App\Models\TicketComment;
use App\Models\TicketAttachment;
use App\Models\Agency;

class Ticket extends Model
{
    protected $fillable = [

    'ticket_id',
    'ticket_status',
    'ticket_resolved_at',

    'requestor_first_name',
    'requestor_middle_name',
    'requestor_last_name',
    'requestor_extension_name',

    'requestor_sex',
    'requestor_email',
    'requestor_mobile_number',
    'requestor_office_address',

    'requestor_region',
    'requestor_province',
    'requestor_city',
    'requestor_organization',
    'requestor_office',
    'requestor_specific_office',

    'ticket_category',

    'purpose_of_request',

    'program',
    'program_others',

    'type_of_knowledge_product',
    'type_of_knowledge_product_others',

    'venue',
    'type_of_activity',
    'date_of_activity',
    'date_of_activity_end',
    'ticket_priority',
    'requestor_position_title',
    'requestor_mobile_number',
    'requestor_office_address',
    'received_ticket_to'
];
    public function programDetails(){
        return $this->belongsTo(Program::class, 'program', 'program_id');
    }

    public function programs(){
        return $this->belongsTo(Program::class, 'program');
    }

    public function requestRegion(){
        return $this->belongsTo(Region::class, 'requestor_region', 'region_code');
    }

    public function requestProvince(){
        return $this->belongsTo(Province::class, 'requestor_province', 'province_code');
    }

    public function requestCity(){
        return $this->belongsTo(City::class, 'requestor_city', 'city_code');
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class)
                    ->whereNull('parent_id')
                    ->latest();
    }

    public function resolutions()
    {
        return $this->hasMany(Resolution::class, 'ticket_id');
    }

    public function activities()
    {
        return $this->hasMany(TicketActivity::class)->latest();
    }

    public function agency(){
        return $this->belongsTo(Agency::class, 'requestor_office', 'group_code');
    }

}
