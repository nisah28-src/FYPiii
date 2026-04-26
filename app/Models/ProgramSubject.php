<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramSubject extends Model
{
    protected $fillable = [
     'program_structure_id','semester_number','subject_id','is_compulsory',
    ];

    public function program_structures() {
       return $this->BelongsTo(ProgramStructure::class); 
    }
}
