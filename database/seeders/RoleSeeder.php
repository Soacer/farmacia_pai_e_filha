<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Enums\UserRole;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (UserRole::cases() as $role) {
            Role::firstOrCreate(
                ['id' => $role->value], // Busca pelo ID (Segurança total)
                ['roles' => $role->label()] // Se não existir, cria com o nome correto
            );
    }
    }
}
