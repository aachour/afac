<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shapes;

class ShapesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $shapes = [
            'Circle',
            'Square',
            'Diamond',
        ];

        foreach ($shapes as $shape) {
            Shapes::updateOrCreate(['name' => $shape]);
        }

    }
}
