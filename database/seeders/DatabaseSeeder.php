<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
        // User::factory(10)->create();
        //Cria as Roles
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

    private function createAdminUser(): void
    {
        User::firstOrCreate([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'idRoles' => Role::where('roles', 'admin')->first()->id,
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }
}
