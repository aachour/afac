<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ColumnTypes;

class ColumnTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    

        $types = [
            'General Inputs',
            'Timeline',
            'Accordion Menu',
        ];

        foreach ($types as $type) {
            ColumnTypes::updateOrCreate(['name' => $type]);
        }

    }
}
