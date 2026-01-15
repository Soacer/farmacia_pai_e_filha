<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();
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
            'role' => env('ADMIN_ROLE'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }
}
