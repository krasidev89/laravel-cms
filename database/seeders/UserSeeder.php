<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin',
            'email_verified_at' => now(),
            'password' => 'qwerty',
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);
    }
}
