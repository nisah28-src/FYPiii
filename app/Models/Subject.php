<?php

namespace App\Models;
use App\Enums\SubjectStatus;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subject_name','subject_code','credit_hours',
        'category_type',
    ];

    public function prerequisites()
    {
        return $this->belongsToMany(Subject::class,'subject_prerequisites', 'subject_id','prerequisite_id');
    }
     protected function casts(): array
    {
        return [
            'category_type' => SubjectStatus::class,
        ];
    }

    public function dependents(){
        return $this->belongsToMany(
            Subject::class,
            'subject_prerequisite',
            'prerequisite_id',
            'subject_id',
        );
    }
}
