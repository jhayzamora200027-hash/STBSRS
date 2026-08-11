<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResolutionAttachment extends Model
{
    protected $fillable = [
        'resolution_id',
        'attachment',
        'attachment_path',
        'file_type',
        'file_size',
    ];

    public function resolution()
    {
        return $this->belongsTo(Resolution::class, 'resolution_id');
    }
}
