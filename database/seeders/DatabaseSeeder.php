<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Cria as Classes e Subclasses dos Produtos
        $this->call([
            CategorySeeder::class,
        ]);
        // User::factory(10)->create();
        // Cria as Roles
        $this->call([
            RoleSeeder::class,
        ]);
        // Cria a conta do ADM
        $this->createAdminUser();
        // Cria a conta do TESTER
        $this->call([
            UserSeeder::class,
        ]);
    }

    private function createAdminUser(): void{

        if (Role::where('roles', 'admin')->first()) {
            User::firstOrCreate(
                ['email' => env('ADMIN_EMAIL')], // 1º Array: Apenas o que é ÚNICO (Busca)
                [                                // 2º Array: O que criar se não existir
                    'name' => env('ADMIN_NAME'),
                    'idRoles' => Role::where('roles', 'admin')->first()->id,
                    'password' => Hash::make(env('ADMIN_PASSWORD')),
                    'isActive' => true,
                ]
            );
        }
    }
}
