<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            ArticleSeeder::class,
            AnnouncementSeeder::class,
            EventSeeder::class,
            AchievementSeeder::class,
        ]);
    }
}
