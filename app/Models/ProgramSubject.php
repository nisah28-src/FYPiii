<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramSubject extends Model
{
    protected $fillable = [
     'program_structure_id','semester_number','subject_id','is_compulsory',
    ];

    public function programStructure() {
       return $this->belongsTo(ProgramStructure::class, 'program_structure_id'); 
    }


public function subject() {
    return $this->belongsTo(Subject::class, 'subject_id', 'id');
}

}
