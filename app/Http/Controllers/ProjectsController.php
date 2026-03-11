<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\Entries;
use App\Models\ProgramYears;
use App\Models\ProjectCategories;
use App\Models\Countries;
use App\Models\ProjectGrantees;

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

        $limitEntries = 12;
        $totalPages = ceil($totalEntries / $limitEntries);
        
        $html='<div class="medium black mt-4">You are viewing <u class="small">12</u> or the <u class="small">'.$totalEntries.'</u> initiatives that Afac has supported.</div>';

        $html.='<div class="mt-3 toggleContainer" >
            <label class="pill-toggle">
                <input type="checkbox" id="granteesToggle">
                <span class="pill micro">
                    <span class="knob"></span>
                    <span class="text">Grantees View</span>
                </span>
            </label>
        </div>';
        
        $html.='<div id="projects">';
            $projectIds=[];
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

                        $projectIds[]=$entry->id;

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
            $html .= '<div class="mt-5 pagination-wrapper">
                <div class="pagination">
                    <span class="nav-btn prev disabled">&larr;</span>
                    <div class="pages" style="display:flex; gap:8px;">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $html .= '<a href="javascript:void(0)" class="page-link page-item' . ($i == $page ? ' active' : '') . '" data-page="' . $i . '">' . $i . '</a>';
                        }
                    $html .= '</div>
                    <span class="nav-btn next">&rarr;</span>
                </div>
            </div>

        </div>';

        $html .= "<script>
            $(document).ready(function () {
                var \$wrapper = $('.collection .pagination-wrapper');
                var \$links = \$wrapper.find('.page-link');
                var totalPages = \$links.length;

                function getActivePage() {
                    return parseInt(\$wrapper.find('.page-link.active').data('page')) || 1;
                }

                function setActivePage(page) {
                    \$links.removeClass('active');
                    \$wrapper.find('.page-link[data-page=\"' + page + '\"]').addClass('active');
                }

                function showPagesFrom(page) {
                    \$links.hide();

                    for (var i = page; i <= page + 2; i++) {
                        \$wrapper.find('.page-link[data-page=\"' + i + '\"]').show();
                    }

                    if (page <= 1) {
                        \$wrapper.find('.prev').addClass('disabled');
                    } else {
                        \$wrapper.find('.prev').removeClass('disabled');
                    }

                    if (page + 2 >= totalPages) {
                        \$wrapper.find('.next').addClass('disabled');
                    } else {
                        \$wrapper.find('.next').removeClass('disabled');
                    }
                }

                var visibleStartPage = getActivePage();
                showPagesFrom(visibleStartPage);

                \$wrapper.find('.next').on('click', function () {
                    if ($(this).hasClass('disabled')) return;

                    visibleStartPage += 3;

                    if (visibleStartPage > totalPages) {
                        visibleStartPage = totalPages;
                    }

                    showPagesFrom(visibleStartPage);
                });

                \$wrapper.find('.prev').on('click', function () {
                    if ($(this).hasClass('disabled')) return;

                    visibleStartPage -= 3;

                    if (visibleStartPage < 1) {
                        visibleStartPage = 1;
                    }

                    showPagesFrom(visibleStartPage);
                });

                \$wrapper.find('.page-link').on('click', function () {
                    var page = parseInt($(this).data('page'));

                    setActivePage(page);
                    visibleStartPage = page;
                    showPagesFrom(visibleStartPage);
                });
            });
        </script>";
            

        //get all grantees related to collection of type projects.

        $granteeIds=ProjectGrantees::WHEREIN('project_id',$projectIds)->pluck('grantee_id')->toArray();
        $grantees=Entries::WHERE('published',1)->WHEREIN('id',$granteeIds)->get();
        if($grantees){
            $html.='<div class="collection d-none" id="projectsGrantees" style="padding:0px;">
                <div class="entries">';
                            
                    $entries_count=0;

                    //Fetch all entries
                    foreach($grantees as $key=>$entry)
                    {

                        $image_path = asset('frontend/images/default-image.png');
                        if (!empty($entry->image)) {
                            $image_path = asset('storage/' . $entry->image);
                        }

                        //get entry details
                        $entryDetails=getEntryDetails($entry->type_id,$entry);
                        $entry_title=$entryDetails["entry_title"];
                        $entry_position=@$entryDetails["entry_position"];
                        $entry_text=$entryDetails["entry_text"];
                        $entry_href=$entryDetails["entry_href"];
                        $entry_target=$entryDetails["entry_target"];

                        $html.='<div class="entry">';

                            $labels=getEntryLabels($entry);

                            $html .= view('frontend.entry-hover-animation', [
                                'collection_type_id'=>$entry->type_id,
                                'entry_href'=>$entry_href,
                                'entry_target'=>$entry_target,
                                'image_path'=>$image_path,
                                'entry_title' => $entry_title,
                                'entry_position' => $entry_position,
                                'entry_text' => $entry_text,
                                'title_position'=>$title_position,
                                'with_label' => '1',
                                'labels_position'=>$labels_position,
                                'entry_type_name' => $entry->type->name,
                                'collection_type_id' => '4',
                                'labels' => $labels,
                                'button_text'=>@$button_text,
                                'button_bg_color'=>@$button_bg_color,
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
                                'resource_date'=>$entry->resource_date,
                                'news_date'=>$entry->news_date,
                            ])->render();
                                                                
                        $html .='</div>';

                        //check entries per row
                        $entries_count++;

                        if($entries_count % 4==0){
                            $html.='<div class="clear">&nbsp;</div>';
                        }

                    }

                    $html.='<div class="clear"></div>
                    
                </div>
            </div>';
        }
            
        $html.='<script>
            $(document).ready(function(){
                $("#granteesToggle").on("change", function () { 
                    if ($(this).is(":checked")){
                        $("#projectsGrantees").removeClass("d-none");
                        $("#projects").addClass("d-none");
                    } 
                    else{
                        $("#projectsGrantees").addClass("d-none");
                        $("#projects").removeClass("d-none");
                    }
                });
            });
        </script>';

        return $html;

    }

}
