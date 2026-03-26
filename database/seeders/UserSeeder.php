<?php

namespace Database\Seeders;

use App\Enums\Users;
use App\Models\Role;
use App\Models\User;
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
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'idRoles' => $userCase->value,
                    'password' => Hash::make('1234'),
                    'isActive' => true,
                ]
            );
        }
    }
}
