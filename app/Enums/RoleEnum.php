<?php

namespace App\Enums;

enum RoleEnum: int
{
    case staff = 1;
    case HOP = 2;
    case HOD = 3;

    public function label():string 
    {
        return match($this) {
            self::staff => 'staff',
            self::HOP => 'Head Of Program',
            self::HOD => 'Head Of Department',
        };
    }
}
