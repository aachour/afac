<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Types;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Events',
            'Programs',
            'News',
            'Resources',
            'Supported Projects',
        ];

        foreach ($types as $type) {
            Types::create(['name' => $type]);
        }
    

    }
}
