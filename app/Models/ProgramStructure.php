<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStructure extends Model
{
    protected $fillable = [
     'program_structure_name','program_id', 'version', 'status','created_by'
    ];

    public function programSubjects() {
        return $this->hasMany(ProgramSubject::class, 'program_structure_id');
    }

    public function scopeMine($query)
{
    return $query->where('created_by', auth()->id());
}
}
