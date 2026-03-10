<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Entries;
use App\Models\ProgramYears;
use App\Models\ProjectCategories;
use App\Models\Countries;

class ProjectsController extends Controller
{
    
    public function projects()
    {

        $page=Pages::where('name','Projects')->first();
        
        $headerBgCode=$footerBgCode='#FFF';
        if($page)
        {
            $headerBgCode=$page->headerBgColor->code;
            $footerBgCode=$page->footerBgColor->code;
        }

        //get all filters
        $projects = Entries::where([
            'type_id'   => 3,
            'published' => 1
        ])->get(['id', 'project_categories_id', 'project_countries_id']);

        $project_ids = $projects->pluck('id')->toArray();
        
        //Categories
        $project_categories_id = $projects->pluck('project_categories_id')->toArray(); 

        $categoryIds = $projects
            ->pluck('project_categories_id')   // Get JSON strings
            ->map(function ($item) {
                return json_decode($item, true); // Decode to array
            })
            ->flatten()  // Merge all arrays into one
            ->unique()   // Optional: remove duplicates
            ->values()   // Reset keys
        ->toArray();
        
        $project_categories = ProjectCategories::whereIn('id', $categoryIds)
            ->pluck('name', 'id');

        //Countries
        $countryIds = $projects
            ->pluck('project_countries_id')   // Get JSON strings
            ->map(function ($item) {
                return json_decode($item, true); // Decode to array
            })
            ->flatten()  // Merge all arrays into one
            ->unique()   // Optional: remove duplicates
            ->values()   // Reset keys
        ->toArray();
       
        $project_countries = Countries::whereIn('id', $countryIds)
            ->pluck('name', 'id')
        ->toArray();

        //Programs and Years
        $project_programs=[];
        $project_program_years=[];

        $programYears = ProgramYears::whereIn('id', function ($query) use ($project_ids) {
            $query->select('program_year_id')
                ->from('program_year_projects')
                ->whereIn('project_id', $project_ids);
        })->get();

        foreach($programYears as $programYear){
            //Set Programs
            $program=$programYear->program;
            if ($program?->id && !in_array($program?->id, array_column($project_programs, 'id'))) {
                $project_programs[]=[
                    'id'   => $program?->id,
                    'name' => $program?->program_title,
                ];
            }

            //Set Years
            if ($programYear->year && !in_array($programYear->year, array_column($project_program_years, 'name'))) {
                $project_program_years[] = [
                    //'id'   => $programYearId,
                    'id'   => $programYear->id,
                    'name' => $programYear->year,
                ];
            }
        }
        
        usort($project_program_years, function ($a, $b) {
            return (int) $b['name'] <=> (int) $a['name'];
        });

        return view('frontend.projects', [
            'headerBgCode'=>$headerBgCode,
            'footerBgCode'=>$footerBgCode,
            'project_categories' => $project_categories,
            'project_countries' => $project_countries,
            'project_programs' => $project_programs,
            'project_program_years' => $project_program_years,
        ]);

    }

    public function getProjects(Request $request){

        $filters = $request->filters;

        $page= $filters["page"] ?? 1;

        $data=buildEntriesQuery("",$filters,[]);

        $totalEntries = $data['totalEntries'] ?? '0';
        $entries = $data['entries'] ?? collect();

        $limitEntries = 80;
        $totalPages = ceil($totalEntries / $limitEntries);
        
        $html='';
                
        if(count($entries)>0)
        {

            $html.='<div class="entries">

                <style>
                    @media(min-width:900px){
                        .collection .entries > .entry:nth-child(4n of .entry){
                            margin-right:0 !important;
                        }
                    }
                </style>';

                $title_position='top:15px;';
                $labels_position='bottom:15px;';

                //Fetch all entries
                
                $entries_count=0;
                
                foreach($entries as $key=>$entry)
                {

                    $image_path = asset('frontend/images/default-image.png');
                    if (!empty($entry->image)) {
                        $image_path = asset('storage/' . $entry->image);
                    }

                    //get entry details
                    $entryDetails=getEntryDetails('3',$entry);
                    $entry_title=$entryDetails["entry_title"];
                    $entry_text=$entryDetails["entry_text"];
                    $entry_href=$entryDetails["entry_href"];
                    $entry_target=$entryDetails["entry_target"];

                    $html.='<div class="entry">';

                        $labels=getEntryLabels($entry);

                        $html .= view('frontend.entry-hover-animation', [
                            'collection_type_id'=>'3',
                            'entry_href'=>$entry_href,
                            'entry_target'=>$entry_target,
                            'image_path'=>$image_path,
                            'entry_title' => $entry_title,
                            'entry_text' => $entry_text,
                            'title_position'=>$title_position,
                            'with_label' => '1',
                            'labels_position'=>$labels_position,
                            'entry_type_name' => $entry->type->name,
                            'labels' => $labels,
                            'button_text'=>'Press',
                            'button_bg_color'=>'#F1F1F1',
                            'featured'=>'0',
                            'event_category_name'=>$entry->eventCategory?->name,
                            'event_start_date'=>$entry->event_start_date,
                            'event_end_date'=>$entry->event_end_date,
                            'program_start_date'=>$entry->program_start_date,
                            'program_end_date'=>$entry->program_end_date,
                            'project_categories'=>$entry->projectCategoriesName(json_decode($entry->project_categories_id ?? '[]', true) ?? []),
                            'project_countries'=>$entry->projectCountries(json_decode($entry->project_countries_id ?? '[]', true) ?? []),
                            'grantee_categories'=>$entry->granteeCategories(json_decode($entry->grantee_categories_id ?? '[]', true) ?? []),
                            'grantee_country'=>$entry->granteeCountry?->name,
                            'jury_country_id'=>$entry->jury_country_id,
                            'resource_category_name'=>$entry->resourceCategory?->name,
                            'resource_date'=>$entry->resource_date,
                            'news_date'=>$entry->news_date,
                        ])->render();
                                                            
                    $html .='</div>';

                    $entries_count++;
 
                    if($entries_count==$limitEntries){break;}

                }

                $html.='<div class="clear"></div>';
                
                
            $html.='</div>';

        }

        // Pagination links
        $html .= "<div class='pagination mt-4'>";
        for($i = 1; $i <= $totalPages; $i++){
            $active = ($i == $page) ? "active" : "";
            $html .= "<a class='pagination-box $active' data-page='$i'>$i</a>";
        }
        $html .= "</div>";

        return $html;
    }

}
