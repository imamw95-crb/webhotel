<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@theicon.id'],
            ['name' => 'Admin', 'password' => bcrypt('admin123')]
        );
    }
}
