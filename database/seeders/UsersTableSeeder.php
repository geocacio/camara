<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masterRole = Role::where('name', 'master')->first();

        $master = User::create([
            'name' => 'Master',
            'email' => 'master@email.com',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);
        $master->roles()->attach($masterRole);
    }
}
