<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public $timestamps = false;

    protected $fillable = [
        'psgc_code',
        'name',
        'region_code',
        'province_code',
        'city_code',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'region_code');
    }
}