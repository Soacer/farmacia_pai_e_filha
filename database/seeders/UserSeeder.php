<?php

namespace Database\Seeders;

use App\Enums\Users;
use App\Models\Customer;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        foreach (Users::cases() as $userCase) {
            $data = $userCase->defaultData();
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'idRoles' => $userCase->value,
                    'password' => Hash::make('1234'),
                    'isActive' => true,
                ]
            );
            if ($userCase === Users::CUSTOMER) {
                Customer::updateOrCreate(
                    ['cpf' => '692.727.684-03'], // CPF Gerado por Gerador de CPF
                    [
                        'name' => 'Customer',
                        'phone' => '71999999999',
                        'birth_date' => '2026-01-01',
                        'idUsers' => $user->id,
                    ]
                );
            }
            if ($userCase === Users::EMPLOYEE) {
                Employee::updateOrCreate(
                    ['cpf' => '692.727.684-03'],
                    [   
                        'phone' => '71988887777',
                        'birth_date' => '1990-01-01',
                        'salary' => 2500.00,
                        'hire_date' => now()->format('Y-m-d'),
                        'job_title' => 'Balconista',
                        'idUsers' => $user->id,
                    ]
                );
            }
        }
    }
}
