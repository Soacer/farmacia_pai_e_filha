<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $this->createAdminUser();

        $this->call([
            CategorySeeder::class,   // Necessário para os Produtos
            OccupationSeeder::class, // Necessário para os Funcionários/Users
            UserSeeder::class,       // Outros usuários de teste
            ProductSeeder::class,    // Os 208 produtos da vitrine
        ]);
    }

    private function createAdminUser(): void
    {
        try {
            $adminRole = Role::where('name', 'admin')->first() ?? Role::where('id', 1)->first();

            if ($adminRole) {
                User::firstOrCreate(
                    ['email' => env('ADMIN_EMAIL', 'admin@admin.com')],
                    [
                        'name'     => env('ADMIN_NAME', 'Administrador'),
                        'idRoles'  => $adminRole->id, // Usa o ID (Inteiro) da tabela roles
                        'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                        'isActive' => true,
                    ]
                );
            } else {
                Log::warning('Role de Administrador não encontrada. O usuário admin não foi criado.');
            }
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário admin no Seeder: ' . $e->getMessage());
        }
    }
}