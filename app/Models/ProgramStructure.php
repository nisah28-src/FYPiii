<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStructure extends Model
{
    protected $fillable = [
     'program_structure_name','program_id', 'version', 'status','created_by'
    ];

    public function program_subjects() {
        return $this->BelongsTo(ProgramSubject::class);
    }
}
