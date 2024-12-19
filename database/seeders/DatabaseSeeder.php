<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            DashboardTableSeeder::class,
            AdminSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            TranslationSeeder::class,
            ProjectSeeder::class,
            ExperienceSeeder::class,
        ]);
        User::factory(19)->create();
    }
}
