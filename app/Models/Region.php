<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    public $timestamps = false;

    protected $fillable = [
        'psgc_code',
        'region_code',
        'name',
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class, 'region_code', 'region_code');
    }
}