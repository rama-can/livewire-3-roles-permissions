<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Next.js GitHub Markdown Blog',
                'description' => 'A modern, feature-rich blogging platform that uses GitHub as a CMS. Transform your Markdown files into a beautiful, responsive blog with minimal setup. Perfect for developers who want to keep their content in GitHub and integrate a blog into their Next.js applications.',
                'url' => '#',
                'tags' => ['Next.js', 'Markdown', 'GitHub', 'Tailwind CSS']
            ],
            [
                'name' => 'Laravel Localization',
                'description' => 'A Laravel package to handle localization. It supports URL prefixes, domain-based locales, and internationalization. Out of the box, it supports the Laravel routes, Eloquent models, and Blade views.',
                'url' => '#',
                'tags' => ['Laravel', 'Localization', 'Internationalization']
            ],
            [
                'name' => 'Laravel Livewire Sluggable',
                'description' => 'A Laravel Livewire component to generate a unique slug for your Eloquent models. It automatically generates a unique slug when the title is changed and validates the uniqueness of the slug.',
                'url' => '#',
                'tags' => ['Laravel', 'Livewire', 'Alpine.js']
            ]
        ];

        foreach ($projects as $project) {
            \App\Models\Project::create($project);
        }
    }
}
