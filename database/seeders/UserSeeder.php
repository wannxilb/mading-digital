<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Pak Dedi',
                'email' => 'admin.dedi@mading.sch.id',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'class' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Bu Budiarti',
                'email' => 'admin.budi@mading.sch.id',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'class' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Rahma',
                'email' => 'siswa.rahma@mading.sch.id',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'class' => 'XI IPA 1',
                'is_active' => true,
            ],
            [
                'name' => 'Rian',
                'email' => 'siswa.rian@mading.sch.id',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'class' => 'X 3',
                'is_active' => true,
            ],
            [
                'name' => 'Salsa',
                'email' => 'siswa.salsa@mading.sch.id',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'class' => 'XI IPS 2',
                'is_active' => true,
            ],
            [
                'name' => 'Nadia',
                'email' => 'siswa.nadia@mading.sch.id',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'class' => 'XII IPA 1',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
