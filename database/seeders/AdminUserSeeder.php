<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mading.sch.id'],
            [
                'name' => 'Admin Mading',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
