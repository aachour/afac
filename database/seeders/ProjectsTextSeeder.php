<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entries;
use App\Models\Sections;
use App\Models\PageSections;
use App\Models\SectionColumns;
use App\Models\ColumnGeneral;



class ProjectsTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $projects=Entries::WHERE('type_id','3')->ORDERBY('id','ASC')->get();
        foreach($projects as $project){
            $projectId=$project->id;
            $text=$project->project_text;
            $text_arabic=$project->project_text_arabic;

            //create new section and page section
            $section = Sections::create([
                'entry_id' => $projectId,
                'name' => 'About the project',
            ]);

            $sectionId = $section->id;

            $pageSection=PageSections::create([
                'entry_id' => $projectId,
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
                'title' => 'About the project',
                'title_arabic' => 'عن المشروع',
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
