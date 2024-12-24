<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buatkan role dan permission pada umumnya
        $admin = Role::firstOrCreate(['name' => 'Super Admin']);
        $staff = Role::firstOrCreate(['name' => 'Staff']);
        $member = Role::firstOrCreate(['name' => 'Member']);

        $users = [
            [
                'id' => '9d8e1dd0-eeb8-430f-a9ff-502e77ed0dc5',
                'name' => 'Rama Can',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@gmail.com',
                'username' => 'staff',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Member',
                'email' => 'member@gmail.com',
                'username' => 'member',
                'password' => Hash::make('password'),
            ],
        ];

        // creating user and assign role
        foreach ($users as $user) {
            $user = \App\Models\User::factory()->create($user);
            if ($user->username === 'admin') {
                $user->assignRole('Super Admin');
            } elseif ($user->username === 'staff') {
                $user->assignRole('Staff');
            } elseif ($user->username === 'member') {
                $user->assignRole('Member');
            }
        }

        $permissions = [
            'create',
            'read',
            'update',
            'delete',
        ];

        $moduls = [
            'dashboard',
            'admin',
            'users',
            'roles',
            'permissions',
            'settings',
            'profile',
            'posts',
            'categories',
            'tags',
            'subscriptions',
        ];

        foreach ($moduls as $modul) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission . ' ' . $modul]);
            }
        }

        // Generate permissions for modul read-only
        $customModules = [
            'read dashboard',
            'read audit-logs',
            'delete audit-logs',
        ];
        foreach ($customModules as $module) {
            Permission::firstOrCreate(['name' => $module]);
        }

        // berikan permission pada role admin
        $admin->givePermissionTo(Permission::all());

        // berikan permission pada role staff
        $staff->givePermissionTo([
            'read dashboard',
            'read users',
            'read roles',
            'read permissions',
            'read settings',
            'read profile',
            'read posts',
            'read categories',
            'read tags',
        ]);

        // berikan permission pada role member
        $member->givePermissionTo([
            'read dashboard',
            'read profile',
        ]);
    }
}
