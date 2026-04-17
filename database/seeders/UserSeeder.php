<?php

namespace Database\Seeders;

use App\Enums\Users as UserEnum;
use App\Models\Customer;
use App\Models\User;
use App\Models\Employee;
use App\Models\Occupation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UserEnum::cases() as $userCase) {
            $data = $userCase->defaultData();

            // Criamos ou atualizamos o Usuário (UUID gerado automaticamente pela Trait)
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'idRoles' => $userCase->value, // Mantendo Inteiro conforme sua arquitetura
                    'password' => Hash::make('1234'),
                    'isActive' => true,
                ]
            );

            // Regra para Clientes
            if ($userCase === UserEnum::CUSTOMER) {
                Customer::updateOrCreate(
                    ['idUsers' => $user->id], // Busca pelo UUID do usuário vinculado
                    [
                        'name' => 'Cliente Teste',
                        'cpf' => '69272768403', 
                        'phone' => '71999999999',
                        'birth_date' => '2000-01-01',
                    ]
                );
            }

            if ($userCase === UserEnum::EMPLOYEE) {
                // SEGURANÇA: Busca a ocupação 'Balconista' ou pega a primeira disponível
                // Isso evita o erro 1452 caso o ID 4 não exista.
                $occupation = Occupation::where('name', 'like', '%Balconista%')->first() 
                              ?? Occupation::first();

                if ($occupation) {
                    Employee::updateOrCreate(
                        ['idUsers' => $user->id],
                        [   
                            'cpf' => '69272768403',
                            'phone' => '71988887777',
                            'birth_date' => '1990-01-01',
                            'salary' => 2500.00,
                            'hire_date' => now()->format('Y-m-d'),
                            'idOccupations' => $occupation->id,
                        ]
                    );
                }
            }
        }
    }
}