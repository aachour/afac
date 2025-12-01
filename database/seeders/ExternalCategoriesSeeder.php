<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExternalCategories;


class ExternalCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $categories = [
            'Article',
            'Video',
            'Audio',
            'Downloadable File',
        ];

        foreach ($categories as $category) {
            ExternalCategories::updateOrCreate(['name' => $category]);
        }
    }
}
