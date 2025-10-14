<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectCategories;

class ProjectCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories=
        [
            'Memory',
            'Identity',
            'Home',
            'Conflict',
            'Family',
            'Mental Health',
            'Racial Justice',
        ];

        foreach ($categories as $category) {
            ProjectCategories::updateOrCreate(['name' => $category]);
        }
    }
}
