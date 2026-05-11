<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalRequest extends Model
{
    protected $fillable = [
        'program_structure_id',
        'status',
        'requested_by',
        'reviewed_by',
        'remarks',
    ];

    public function programStructure() {
        return $this-> belongsTo(ProgramStructure::class);
    }

    public function histories() {
        return $this->hasMany(ApprovalHistory::class);
    }

    public function request() {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function review(){
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
