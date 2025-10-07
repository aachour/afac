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
            'Event',
            'Program',
            'Open Call',
            'Supported project',
            'Grantee',
            'Jury',
            'Resources',
            'News',
        ];

        foreach ($types as $type) {
            Types::updateOrCreate(['name' => $type]);
        }
    

    }
}
