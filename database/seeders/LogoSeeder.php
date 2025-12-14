<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Logo;


class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elements=[
            ['Diamon 1','text','text arabic','1'],
            ['Diamon 2','text','text arabic','1'],
            ['Diamon 3','text','text arabic','1'],
            ['Vertical 1','text','text arabic','1'],
            ['Vertical 2','text','text arabic','1'],
            ['Vertical 3','text','text arabic','1'],
            ['Circle 1','text','text arabic','1'],
            ['Circle 2','text','text arabic','1'],
            
        ];

        foreach ($elements as $element) {
            Logo::updateOrCreate(['name' => $element[0],'text' => $element[1],'text_arabic' => $element[2],'status' => $element[3]]);
        }
    }
}
