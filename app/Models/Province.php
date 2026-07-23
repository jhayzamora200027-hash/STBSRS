<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    public $timestamps = false;

    protected $fillable = [
        'psgc_code',
        'name',
        'region_code',
        'province_code',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'region_code');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'province_code', 'province_code');
    }
}