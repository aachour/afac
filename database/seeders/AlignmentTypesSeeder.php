<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AlignmentTypes;

class AlignmentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alignments = [
            'Left',
            'Right',
            'Center',
        ];

        foreach ($alignments as $alignment) {
            AlignmentTypes::updateOrCreate(['name' => $alignment]);
        }
    }
}
