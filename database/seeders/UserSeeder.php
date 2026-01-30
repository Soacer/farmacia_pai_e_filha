<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::factory()->create([
            'name' => 'Tester User Employee',
            'email' => "employee@employee.com",
            'idRoles' => Role::where('roles', 'employee')->first()->id,
            'password' => hash::make('1234'),
            'isActive' => true,
        ]);
    }
}
