<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\TranslationLoader\LanguageLine as Translation;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'group' => 'general',
                'key' => 'site_name',
                'text' => ['en' => 'Rama Can', 'id' => 'Rama Can'],
            ],
            [
                'group' => 'general',
                'key' => 'site_description',
                'text' => [
                    'en' => 'A slowly growing collection of work and project notes, containing things I\'ve learned or created over the years.',
                    'id' => 'Sebuah koleksi catatan kerja dan proyek yang terus berkembang perlahan-lahan, berisi berbagai hal yang telah saya pelajari atau ciptakan selama bertahun-tahun.'
                ],
            ],
            [
                'group' => 'frontend',
                'key' => 'frontend_personal_section_title',
                'text' => ['en' => "Hi, I'm Rama Can", 'id' => "Hai, Saya Rama Can"],
            ],
            [
                'group' => 'frontend',
                'key' => 'frontend_personal_section_description',
                'text' => [
                    'en' => 'Welcome to my digital garden, a slowly growing collection of work and project notes containing things I\'ve learned or created over the years.',
                    'id' => 'Selamat datang di taman digital saya, sebuah koleksi catatan kerja dan proyek yang terus berkembang perlahan-lahan, berisi berbagai hal yang telah saya pelajari atau ciptakan selama bertahun-tahun.'
                ],
            ],
            [
                'group' => 'frontend',
                'key' => 'works_with_technologies',
                'text' => ['en' => 'Works with technologies', 'id' => 'Bekerja dengan teknologi'],
            ],
            [
                'group' => 'general',
                'key' => 'download_cv',
                'text' => ['en' => 'Download CV', 'id' => 'Unduh CV'],
            ],
            [
                'group' => 'frontend',
                'key' => 'frontend_blogs_section_description',
                'text' => ['en' => 'Some of my life stories and experiences created with heart.', 'id' => 'Beberapa kisah dan pengalaman hidup saya yang dibuat dengan hati.'],
            ],
            [
                'group' => 'frontend',
                'key' => 'frontend_projects_section_description',
                'text' => ['en' => 'Explore a curated list of projects showcasing my journey as a developer.', 'id' => 'Jelajahi daftar proyek yang telah dikurasi yang menampilkan perjalanan saya sebagai pengembang.'],
            ],
            [
                'group' => 'general',
                'key' => 'read_more',
                'text' => ['en' => 'Read More', 'id' => 'Baca Selengkapnya'],
            ],
            [
                'group' => 'general',
                'key' => 'view_project',
                'text' => ['en' => 'View Project', 'id' => 'Lihat Proyek'],
            ],
            [
                'group' => 'general',
                'key' => 'hr_Ahmad',
                'text' => ['en' => 'The best of humans are those who are most beneficial to others.', 'id' => 'Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia'],
            ],
            [
                'group' => 'general',
                'key' => 'all_rights_reserved',
                'text' => ['en' => 'All Rights Reserved.', 'id' => 'Semua Hak Cipta Dilindungi Undang-Undang.'],
            ],
        ];

        foreach ($data as $item) {
            Translation::create([
                'group' => $item['group'],
                'key' => $item['key'],
                'text' => [
                    'en' => $item['text']['en'],
                    'id' => $item['text']['id'],
                ],
            ]);
        }
    }
}
