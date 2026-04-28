<?php

namespace App\Models;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
     protected $fillable = [
        'role',
    ];


    public function users(){
        return $this->belongsToMany(User::class, 'user_roles','role_id','user_id')->withPivot('program_id');
    }

    protected $casts = [
    'role_id' => RoleEnum::class,
];
}
