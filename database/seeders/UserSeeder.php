<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->times(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@email',
            'email_verified_at' => now(),
            'password' => Hash::make('kf,jhfnjhsz'), // лабораторія
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);
    }
}
