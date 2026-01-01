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
            'Supported Project',
            'Grantee',
            'Jury',
            'Resource',
            'News',
            'External',
            'Team',
            'Member',
        ];

        foreach ($types as $type) {
            Types::updateOrCreate(['name' => $type]);
        }
    

    }
}
