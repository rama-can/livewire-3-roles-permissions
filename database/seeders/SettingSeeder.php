<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Rama Can', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_logo', 'value' => null, 'type' => 'image'],
            ['group' => 'general', 'key' => 'site_thumbnail', 'value' => null, 'type' => 'image'],
            ['group' => 'general', 'key' => 'site_url', 'value' => 'https://ramacan.dev', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_theme', 'value' => '#ffffff', 'type' => 'color'],
            ['group' => 'general', 'key' => 'cv', 'value' => null, 'type' => 'file'],
            ['group' => 'general', 'key' => 'personal_image', 'value' => null, 'type' => 'image'],
            ['group' => 'general', 'key' => 'pagination_limit', 'value' => '10', 'type' => 'number'],
            [
                'group' => 'general',
                'key' => 'default_role',
                'value' => 'member',
                'type' => 'select',
                'attributes' => [
                    'options' => [
                        ['label' => 'Super Admin', 'value' => 'super_admin'],
                        ['label' => 'Staff', 'value' => 'staff'],
                        ['label' => 'Member', 'value' => 'member'],
                    ],
                ]
            ],
            [
                'group' => 'frontend',
                'key' => 'menus',
                'type' => 'json',
                'value' => json_encode([
                    ['label' => 'Home', 'route_name' => 'home', 'is_active' => true],
                    ['label' => 'Work', 'route_name' => 'works.index', 'is_active' => false],
                    ['label' => 'Projects', 'route_name' => 'projects.index', 'is_active' => true],
                    ['label' => 'Blogs', 'route_name' => 'blogs.index', 'is_active' => true],
                    ['label' => 'Contact', 'route_name' => 'contact', 'is_active' => false],
                ]),
            ],
            [
                'group' => 'general',
                'key' => 'social_links',
                'type' => 'json',
                'value' => json_encode([
                    ['label' => 'Twitter', 'icon' => 'fab fa-twitter', 'url' => 'https://twitter.com/_ramacan'],
                    ['label' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => 'https://www.instagram.com/_ramacan'],
                    ['label' => 'LinkedIn', 'icon' => 'fab fa-linkedin', 'url' => 'https://linkedin.com/in/ramacan'],
                    ['label' => 'GitHub', 'icon' => 'fab fa-github', 'url' => 'https://github.com/rama-can'],
                ]),
            ],
        ];

        foreach ($settings as $setting) {
            $attributes = $setting['attributes'] ?? null;
            unset($setting['attributes']);

            $createdSetting = \App\Models\Setting::firstOrCreate(
                [
                    'group' => $setting['group'],
                    'key' => $setting['key'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                ],
                $setting
            );

            if ($attributes) {
                $createdSetting->update(['attributes' => $attributes]);
            }
        }
    }
}
