<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventCategories;


class EventCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $types=['Panel','Workshop','Talk','Screening'];

        foreach ($types as $type) {
            EventCategories::updateOrCreate(['name' => $type]);
        }
    }
}
