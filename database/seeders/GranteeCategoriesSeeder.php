<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GranteeCategories;

class GranteeCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $categories = [
            'Cat1',
            'Cat2',
            'Cat3',
        ];

        foreach ($categories as $category) {
            GranteeCategories::updateOrCreate(['name' => $category]);
        }
    }
}
