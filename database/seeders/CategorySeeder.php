<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori Utama: Technology
        $technology = Category::create(['parent_id' => null]);
        $technology->translateOrNew('en')->name = 'Technology';
        $technology->translateOrNew('id')->name = 'Teknologi';
        $technology->save();

        // Subkategori: Programming
        $programming = Category::create(['parent_id' => $technology->id]);
        $programming->translateOrNew('en')->name = 'Programming';
        $programming->translateOrNew('id')->name = 'Pemrograman';
        $programming->save();

        // Subkategori: Gadgets
        $gadgets = Category::create(['parent_id' => $technology->id]);
        $gadgets->translateOrNew('en')->name = 'Gadgets';
        $gadgets->translateOrNew('id')->name = 'Gawai';
        $gadgets->save();

        // Kategori Utama: Lifestyle
        $lifestyle = Category::create(['parent_id' => null]);
        $lifestyle->translateOrNew('en')->name = 'Lifestyle';
        $lifestyle->translateOrNew('id')->name = 'Gaya Hidup';
        $lifestyle->save();

        // Subkategori: Fitness
        $fitness = Category::create(['parent_id' => $lifestyle->id]);
        $fitness->translateOrNew('en')->name = 'Fitness';
        $fitness->translateOrNew('id')->name = 'Kebugaran';
        $fitness->save();

        // Subkategori: Travel
        $travel = Category::create(['parent_id' => $lifestyle->id]);
        $travel->translateOrNew('en')->name = 'Travel';
        $travel->translateOrNew('id')->name = 'Perjalanan';
        $travel->save();
    }
}
