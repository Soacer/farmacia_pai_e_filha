<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case EMPLOYEE = 2;
    case CUSTOMER = 3;

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'admin',
            self::EMPLOYEE => 'employee',
            self::CUSTOMER => 'customer',
        };
    }
}

?>