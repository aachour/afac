<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Colors;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $colors=[
            ['Blue Lightest' , '#D2F8F'],
            ['Blue Light' , ' #9DD1FF'],
            ['Blue Dark' , ' #3388ff'],
            ['Blue Darkest' , ' #002B68'],
            ['Green Lightest' , ' #DBFFD9'],
            ['Green Light' , ' #7CE57F'],
            ['Green Dark' , ' #00B371'],
            ['Green Darkest' , ' #004134'],
            ['Pink Lightest' , ' #FEDEFF'],
            ['Pink Light' , ' #FF99FD'],
            ['Pink Dark' , ' #FF1A6D'],
            ['Pink Darkest' , ' #5A004B'],
            ['Yellow Lightest' , ' #FFFDC2'],
            ['Yellow Light' , ' #FFD029'],
            ['Yellow Dark' , ' #FF5A01'],
            ['Yellow Darkest' , ' #5C2C00'],
        ];

        foreach ($colors as $color) {
            Colors::create(['name' => $color[0],'code'=>$color[1]]);
        }

    }
}
