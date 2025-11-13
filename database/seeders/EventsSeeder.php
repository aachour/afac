<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Entries;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */

    public function run(): void
    {
        $images=
        [
            'entries/qd6nO4xKbeIlQ3h4UEbZRRwF1B3ubjIALPvJIc4k.jpg',
            'entries/RqLxM6noQCBeUFQLQbq2oHFT5vs3qKQPpWHoW2rL.jpg',
            'entries/OjCWB6nuBHGGVM4IgyC6TCBpdrlQ17I1S5Hx0SfC.jpg',
            'entries/VRwhavcLy5uVmV0qAv7v4R6g8kd8uglWLegaV4Ut.jpg',
            'entries/9Fm9r5eNI9lKs8dhlyp9ce3nmJxwYm5WVs79jzxf.jpg',
            'entries/LKJF31m7tJ2PFHOxDWO1JAhYdY2XfVIJIFD3ML3J.jpg',
            'entries/6mFqY8D4DeZmny82KZwAfM2iX57SrMn9X3Wbmcwv.jpg',
        ];

        $image_featured=
        [
            'entries/ZMNc58X6hdo11lWFCSgAPUoBPvveYxNOJ9liRNS6.jpg',
            'entries/7c10thiwMvgmyzh7XGfmPYF7S8Z11sgHKhlk075P.jpg',
            'entries/CtHGHTQfRyHdka0esRnD0pdiIYjmlqI3IpuSE7ds.jpg',
            'entries/b2dkCAtP6r44y5Qh8FH6Ht34ovPazMoI2Q6GU5n0.jpg',
            'entries/VeuBojTpKIwlCY5IuXiyXKVJw2QsW2DCtbNYWwAb.jpg',
            'entries/UrUR1Zozcej8zfs2bDfHsDTs3JU4iqfAqVfQVfj8.jpg',
            'entries/0GcLswTQ9oNGd3COkUfui5W0pBzlj7shL0HNTOQN.jpg',
        ];

        $image_width=['2','2','2','2','2','2','2'];

        $background_color_id=['8','8','8','8','8','8','8'];

        $button_link=
        [
           'google.com',
           'google.com',
           'google.com',
           'google.com',
           'google.com',
           'google.com',
           'google.com',
        ];

        $button_value=
        [
            'Learn More',
            'Read more',
            'Learn More',
            'Learn More',
            'Learn More',
            'Learn More',
            'Learn More',
        ];
        
        $event_category_id=['1','1','2','2','3','4','4'];


        $event_title=
        [
            'Celebration of Art',
            'War Never Ends',
            'One with Nature',
            'Sports for Health',
            'The Final Example', 
            'One More Example',
            'Nature is Therpay', 
        ];

        $event_text=
        [
            'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 
            
            'The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English.',

            'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',

            'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.',

            'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum',

            'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.',

            'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.'
        ];

        $event_date=
        [
            '11/3/2025',
            '11/4/2025',
            '12/2/2024',
            '11/7/2025',
            '11/10/2025',
            '11/10/2025',
            '11/11/2025',
        ];

        $event_start_time=
        [
            '13:30:00',
            '23:03:00',
            '2:30:00',
            '13:20:00',
            '20:30:00',
            '2:30:00',
            '16:00:00',
        ];

        $event_end_time=
        [
            '14:30:00',
            '14:30:00',
            '5:30:00',
            '15:30:00',
            '22:30:00',
            '4:30:00',
            '17:00:00',
        ];

        foreach($images as $key=>$image){
            $entry=new Entries();
            $entry->type_id='1';
            $entry->image=$image;
            $entry->image_featured=$image_featured[$key];
            $entry->image_width=$image_width[$key];
            $entry->background_color_id=$background_color_id[$key];
            $entry->button_link=$button_link[$key];
            $entry->button_value=$button_value[$key];
            $entry->event_category_id=$event_category_id[$key];
            $entry->event_title=$event_title[$key];
            $entry->event_text=$event_text[$key];
            $entry->event_date=date('y-m-d',strtotime($event_date[$key]));
            $entry->event_start_time=$event_start_time[$key];
            $entry->event_end_time=$event_end_time[$key];
            $entry->save();
        }

    }
}
