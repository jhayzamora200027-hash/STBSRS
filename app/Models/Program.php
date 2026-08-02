<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'program_id',
        'program',
        'created_by',
    ];

    /**
     * User who created the program.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tickets(){
        return $this->hasMany(Ticket::class, 'program', 'id');
    }
}