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
                "type_id" => 1,
                "name" => "Events",
                "name_arabic" => "Events",
                "show_name" => 1,
                "description" => "<p>It is a long established fact that a reader...</p>",
                "description_arabic" => "<p>It is a long established fact that a reader...</p>",
                "description_position" => 1,
                "with_border_bottom" => 0,
                "with_filters" => 0,
                "entries_selection" => 2,
                "entries_number" => null,
                "entries_with_expired" => 0,
                "entries_order" => "1",
                "title_position" => 1,
                "with_label" => 0,
                "entries_layout" => 2,
                "entries_per_row" => 3,
                "with_featured_image" => 1,
                "featured_image_width" => 6,
                "featured_image_background_color_id" => 8,
                "featured_image_description_position" => 0,
                "created_at" => null,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "type_id" => 1,
                "name" => "Another Events",
                "name_arabic" => "Another Events",
                "show_name" => null,
                "description" => "It is a long established fact that a reader will ...",
                "description_arabic" => null,
                "description_position" => 1,
                "with_border_bottom" => 0,
                "with_filters" => 0,
                "entries_selection" => 2,
                "entries_number" => null,
                "entries_with_expired" => 0,
                "entries_order" => "1",
                "title_position" => 1,
                "with_label" => 0,
                "entries_layout" => 2,
                "entries_per_row" => 3,
                "with_featured_image" => 1,
                "featured_image_width" => 6,
                "featured_image_background_color_id" => null,
                "featured_image_description_position" => 0,
                "created_at" => null,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "type_id" => 2,
                "name" => "Programs Collection",
                "name_arabic" => "Programs Collection",
                "show_name" => 1,
                "description" => "It is a long established fact that a reader will ...",
                "description_arabic" => "It is a long established fact that a reader will ...",
                "description_position" => 1,
                "with_border_bottom" => 0,
                "with_filters" => 0,
                "entries_selection" => 2,
                "entries_number" => null,
                "entries_with_expired" => 0,
                "entries_order" => "1",
                "title_position" => 1,
                "with_label" => 0,
                "entries_layout" => 2,
                "entries_per_row" => 3,
                "with_featured_image" => 1,
                "featured_image_width" => 6,
                "featured_image_background_color_id" => 2,
                "featured_image_description_position" => 0,
                "created_at" => null,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "type_id" => 8,
                "name" => "Guides and internal policies",
                "name_arabic" => "Guides and internal policies",
                "show_name" => 1,
                "description" => "<p>Check our internal policies here</p>",
                "description_arabic" => null,
                "description_position" => 1,
                "with_border_bottom" => 0,
                "with_filters" => 0,
                "entries_selection" => 2,
                "entries_number" => null,
                "entries_with_expired" => 0,
                "entries_order" => "1",
                "title_position" => 1,
                "with_label" => 0,
                "entries_layout" => 2,
                "entries_per_row" => 3,
                "with_featured_image" => 1,
                "featured_image_width" => 6,
                "featured_image_background_color_id" => 17,
                "featured_image_description_position" => 0,
                "created_at" => null,
                "updated_at" => null,
                "deleted_at" => null,
            ],
            [
                "type_id" => 6,
                "name" => "test resources",
                "name_arabic" => "test resources",
                "show_name" => 1,
                "description" => "<p>test resources</p>",
                "description_arabic" => null,
                "description_position" => 1,
                "with_border_bottom" => 0,
                "with_filters" => 0,
                "entries_selection" => 2,
                "entries_number" => null,
                "entries_with_expired" => 0,
                "entries_order" => "1",
                "title_position" => 1,
                "with_label" => 0,
                "entries_layout" => 2,
                "entries_per_row" => 3,
                "with_featured_image" => 1,
                "featured_image_width" => 6,
                "featured_image_background_color_id" => 10,
                "featured_image_description_position" => 0,
                "created_at" => null,
                "updated_at" => null,
                "deleted_at" => null,
            ],
        

        ]);

    }
}
