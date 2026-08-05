<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;

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
    'date_of_activity_end',
    'ticket_priority'
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


}
