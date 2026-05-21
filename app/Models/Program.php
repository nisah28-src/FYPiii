<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
     protected $fillable = [
        'program_name', 'is_active',
    ];

    public function hop()
{
    return $this->belongsTo(User::class, 'hop_id');
}
}
