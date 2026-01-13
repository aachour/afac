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
            GranteeCategories::updateOrCreate(['name' => $category]);
        }
    }
}
