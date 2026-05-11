<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    protected $fillable = [
        'approval_request_id',
        'action_by',
        'action',
        'remarks',
    ];

    public function approvalRequest(){
            return $this->belongsTo(ApprovalRequest::class);
    }

    public function actor() {
        return $this->belongsTo(User::class, 'action_by');
    }

    }

