<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Collections;


class CollectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Collections::insert([

            [
                'type_id' =>1,
                'name'=>'Events',
                'name_arabic'=>'Events',
                'description'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                'description_arabic'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                'description_position' => 1,
                'background_color_id' => 6,
                'with_filters' => 1,
                'filter_fields' => null,
                'entries_selection' => 2,
                'entries_number' => 10,
                'entries_with_expired' => 1,
                'entries_order' => 1,
                'title_position' => 1,
                'with_label' => 1,
                'entries_layout' => 2,
                'entries_per_row' => 4,
                'with_featured_image' => 1,
                'featured_image_width' => 2,
                'featured_image_background_color_id' => 8,
                'featured_image_description_position' => 0
            ],

            [
                'type_id' =>1,
                'name'=>'Another Events',
                'name_arabic'=>'Another Events',
                'description'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                'description_arabic'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                'description_position' => 1,
                'background_color_id' => 1,
                'with_filters' => 0,
                'filter_fields' => null,
                'entries_selection' => 2,
                'entries_number' => 8,
                'entries_with_expired' => 0,
                'entries_order' => 3,
                'title_position' => 1,
                'with_label' => 1,
                'entries_layout' => 1,
                'entries_per_row' => 3,
                'with_featured_image' => 0,
                'featured_image_width' => null,
                'featured_image_background_color_id' => null,
                'featured_image_description_position' => 0
            ],

            [
                'type_id' =>2,
                'name'=>'Programs Collection',
                'name_arabic'=>'Programs Collection',
                'description'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                'description_arabic'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                'description_position' => 1,
                'background_color_id' => 1,
                'with_filters' => 0,
                'filter_fields' => null,
                'entries_selection' => 2,
                'entries_number' => 8,
                'entries_with_expired' => 0,
                'entries_order' => 3,
                'title_position' => 1,
                'with_label' => 1,
                'entries_layout' => 1,
                'entries_per_row' => 4,
                'with_featured_image' => 1,
                'featured_image_width' => 1,
                'featured_image_background_color_id' => 2,
                'featured_image_description_position' => 0
            ],

        ]);


    }
}
