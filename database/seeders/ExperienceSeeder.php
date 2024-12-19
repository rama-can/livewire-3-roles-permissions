<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'company' => 'PT. Karya Anak Bangsa',
                'position' => 'Software Engineer',
                'start_date' => '2021-01-01',
                'end_date' => '2021-12-31',
                'description' => 'Developing and maintaining web applications using Laravel and Vue.js.',
                'type' => 'full-time',
                'tags' => ['Laravel', 'Vue.js'],
            ],
            [
                'company' => 'PT. Karya Anak Bangsa',
                'position' => 'Software Engineer',
                'start_date' => '2022-01-01',
                'end_date' => '2022-12-31',
                'description' => 'Developing and maintaining web applications using Laravel and Vue.js.',
                'type' => 'full-time',
                'tags' => ['Laravel', 'Vue.js'],
            ],
            [
                'company' => 'PT. Karya Anak Bangsa',
                'position' => 'Software Engineer',
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'description' => 'Developing and maintaining web applications using Laravel and Vue.js.',
                'type' => 'full-time',
                'tags' => ['Laravel', 'Vue.js'],
            ]
        ];

        foreach ($data as $experience) {
            \App\Models\Experience::create($experience);
        }
    }
}
