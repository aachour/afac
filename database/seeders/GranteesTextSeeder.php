<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entries;
use App\Models\Sections;
use App\Models\PageSections;
use App\Models\SectionColumns;
use App\Models\ColumnGeneral;

class GranteesTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $grantees=Entries::WHERE('type_id','4')->ORDERBY('id','ASC')->get();
        foreach($grantees as $grantee){
            $granteeId=$grantee->id;
            $text=$grantee->grantee_text;
            $text_arabic=$grantee->grantee_text_arabic;

            //create new section and page section
            $section = Sections::create([
                'entry_id' => $granteeId,
                'name' => 'About the Grantee',
            ]);

            $sectionId = $section->id;

            $pageSection=PageSections::create([
                'entry_id' => $granteeId,
                'section_id' => $sectionId,
                'list_order' => '1',
            ]);

            $pageSectionId = $pageSection->id;

            //create first column of type general inputs & add title
            $column1=SectionColumns::create([
                'section_id' => $sectionId,
                'type_id' => '1',
                'alignment_id' => '1',
                'width' => '1',
            ]);

            $column1Id = $column1->id;

            //add title 
            ColumnGeneral::create([
                'section_column_id' => $column1Id,
                'input_type_id' => '1',
                'title' => 'About the Grantee',
                'title_arabic' => 'عن الحاصل على المنحة',
            ]);

            //Create second column of type general inputs & add text
            $column2=SectionColumns::create([
                'section_id' => $sectionId,
                'type_id' => '1',
                'alignment_id' => '1',
                'width' => '1',
            ]);

            $column2Id = $column2->id;

            ColumnGeneral::create([
                'section_column_id' => $column2Id,
                'input_type_id' => '2',
                'text' => $text,
                'text_arabic' => $text_arabic,
            ]);
            
        }

    }
}
