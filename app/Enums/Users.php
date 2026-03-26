<?php

namespace App\Enums;

enum Users: int{
    case EMPLOYEE = 2;
    case CUSTOMER = 3;

    public function label(): string
    {
        return match ($this) {
            self::EMPLOYEE => 'employee',
            self::CUSTOMER => 'customer',
        };
    }

    // DICA: Vamos colocar os dados de teste aqui dentro para o Seeder ficar limpo!
    public function defaultData(): array
    {
        return match ($this) {
            self::EMPLOYEE => [
                'name' => 'Tester User Employee',
                'email' => 'employee@employee.com',
            ],
            self::CUSTOMER => [
                'name' => 'Tester User Customer',
                'email' => 'customer@customer.com',
            ],
        };
    }
}
