<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    /**
     * Use the singular table name 'agency' in the database.
     */
    protected $table = 'agency';
    protected $fillable = [
        'group_code',
        'group_name',
        'directorate_code',
        'status'
    ];
}
