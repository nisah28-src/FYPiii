<?php

namespace App\Enums;

enum SubjectStatus: string
{
    case CORE = 'Core';
    case ELECTIVE = 'Elective';
    case MPU = 'MPU';

    public function label():string 
    {
        return match($this) {
            self::CORE => 'Core Subject',
            self::ELECTIVE => 'Elective Subject',
            self::MPU => 'MPU Subject',
        };
    }
}
