<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InputTypes;

class InputTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $types=['title','text','gallery','video','button']; //'percentage'

        foreach ($types as $type) {
            InputTypes::updateOrCreate(['name' => $type]);
        }

    }
}
