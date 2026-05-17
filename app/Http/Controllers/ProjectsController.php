<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
use App\Models\PageSections;
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

        //get all sections 
        $pageSections=PageSections::WHERE('page_id',$page->id)->ORDERBY('list_order','ASC')->get();

        $pageHTML='';

        foreach($pageSections as $pageSection){
            if($pageSection->section_id){
                $pageHTML.= ViewSection($pageSection->section_id,'EN');  
            }
            else if($pageSection->collection_id){
                $pageHTML.= ViewCollection($pageSection->collection_id,'EN');
            }
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
        
        app()->getLocale() == 'en' ? $project_categories = ProjectCategories::whereIn('id', $categoryIds)->pluck('name', 'id')->toArray() : $project_categories = ProjectCategories::whereIn('id', $categoryIds)->pluck('name_arabic', 'id')->toArray();

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
       
        app()->getLocale() == 'en' ? $project_countries = Countries::whereIn('id', $countryIds)->pluck('name', 'id')->toArray() : $project_countries = Countries::whereIn('id', $countryIds)->pluck('name_arabic', 'id')->toArray();

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
                    'name_arabic' => $program?->program_title_arabic,
                    
                ];
            }

            //Set Years
            if ($programYear->year && !in_array($programYear->year, array_column($project_program_years, 'name'))) {
                $project_program_years[] = [
                    //'id'   => $programYearId,
                    'id'   => $programYear->id,
                    'name' => $programYear->year,
                    'name_arabic' => $programYear->year,
                ];
            }
        }
        
        usort($project_program_years, function ($a, $b) {
            return (int) $b['name'] <=> (int) $a['name'];
        });

        return view('frontend.projects', [
            'headerBgCode'=>$headerBgCode,
            'footerBgCode'=>$footerBgCode,
            'pageHTML'=>$pageHTML,
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
        
        $totalEntriesIds = $data['totalEntriesIds'] ?? collect();
        $totalEntries = $data['totalEntries'] ?? '0';
        $entries = $data['entries'] ?? collect();

        $limitEntries = 12;
        $totalPages = ceil($totalEntries / $limitEntries);
        
        //Get all projects numbers
        $totalProjects=Entries::WHERE('type_id','3')->WHERE('published','1')->WHERENULL('deleted_at')->count();
        
        $html='<div id="projects_title" class="big black mt-4">';
        if(app()->getLocale() == 'en'){
            $html .= 'You are viewing <u class="big">'.$totalEntries.'</u> of the <u class="big">'.$totalProjects.'</u> initiatives that Afac has supported.';
        } else {
            $html .= ' تشاهد الآن <u class="big">'.$totalEntries.'</u> مبادرة من أصل <u class="big">'.$totalProjects.'</u> مبادرة دعمتها آفاق.';
        }
        $html .= '</div>';        

        $html.='<div class="mt-3 toggleContainer" >
            <label class="pill-toggle">
                <input type="checkbox" id="granteesToggle">
                <span class="pill micro">
                    <span class="knob"></span>
                    <span class="text">';if(app()->getLocale() == "en") $html .= 'Grantees View'; else $html .= 'عرض المستفيدين'; $html .= '</span>
                </span>
            </label>
        </div>';
        
        $html.='<div id="projects">';
            if(count($entries)>0)
            {

                $html.='<div class="entries">

                    <style>
                        @media(min-width:1000px){
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

                        $html.='<div class="entry" style="';if(app()->getLocale() == "ar") $html .= 'margin-left:1.5%;'; $html .= '">';

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
                                'button_text'=>'More',
                                'button_text_arabic'=>'المزيد',
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
            $html .= '<div class="mt-5 pagination-wrapper pagination-wrapper-1">
                <div class="pagination">
                    <span class="nav-btn prev prev-1 disabled">' . (app()->getLocale() == 'ar' ? '&rarr;' : '&larr;') . '</span>
                    <div class="pages" style="display:flex; gap:8px;">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $html .= '<a href="javascript:void(0)" class="page-link page-link-1 page-item' . ($i == $page ? ' active' : '') . '" data-page="' . $i . '">' . $i . '</a>';
                        }
                    $html .= '</div>
                    <span class="nav-btn next next-1">' . (app()->getLocale() == 'ar' ? '&larr;' : '&rarr;') . '</span>
                </div>
            </div>

        </div>';
        
        //get all grantees related to filtered projects.
        $granteesIds = ProjectGrantees::whereIn('project_id', $totalEntriesIds)
            ->orderByDesc('id')
            ->pluck('grantee_id')
            ->unique()
            ->values()
            ->toArray();

        $html.='<div class="d-none" id="grantees">
            
            <div id="entries_grantees"></div>
            <div class="mt-5 text-center d-none" id="loader_grantees"><div class="loader"></div></div>';

            // Pagination links
            $limitEntries = 12;
            $totalGrantees=count($granteesIds);
            $totalPages = ceil($totalGrantees / $limitEntries);

            $html .= '<div class="mt-5 pagination-wrapper pagination-wrapper-2" id="pagination_grantees">
                <div class="pagination">
                    <span class="nav-btn prev prev-2 disabled">' . (app()->getLocale() == 'ar' ? '&rarr;' : '&larr;') . '</span>
                    <div class="pages" style="display:flex; gap:8px;">';
                        for ($i = 1; $i <= $totalPages; $i++) { 
                            $html .= '<a href="javascript:void(0)" class="page-link page-link-2 page-item ' . ($i == 1 ? ' active' : '') . '" data-page="' . $i . '">' . $i . '</a>';
                        }
                    $html .= '</div>
                    <span class="nav-btn next next-2">' . (app()->getLocale() == 'ar' ? '&larr;' : '&rarr;') . '</span>
                </div>
            </div>

        </div>';

        //get grantees
        $html.='<script>
            function getGrantees(page){
                $("#entries_grantees").empty();
                $("#loader_grantees").removeClass("d-none");
                $("#pagination_grantees").addClass("d-none");
                $.ajax({
                    url: "'.route('get.grantees').'",
                    method: "POST",
                    data: {
                        page: page,
                        granteesIds: '.json_encode($granteesIds).',
                    },
                    success: function(response) {
                        $("#loader_grantees").addClass("d-none");
                        $("#pagination_grantees").removeClass("d-none");
                        $("#entries_grantees").html(response);
                    },
                    error: function(xhr) {
                        if(xhr.responseJSON && xhr.responseJSON.errors){
                            alert(JSON.stringify(xhr.responseJSON.errors));
                        }
                    }
                });
            }

            $(document).ready(function(){
                getGrantees(1);

                $("#grantees").on("click", ".page-link-2", function () {
                    var page=$(this).attr("data-page"); 
                    getGrantees(page);
                });
                
            });
        </script>';

        
        //Hide show grantees
        $html.='<script>
            $(document).ready(function(){
                $("#granteesToggle").on("change", function () { 
                    if ($(this).is(":checked")){
                        $("#grantees").removeClass("d-none");
                        $("#projects").addClass("d-none");
                    } 
                    else{
                        $("#grantees").addClass("d-none");
                        $("#projects").removeClass("d-none");
                    }
                });
            });
        </script>';


        //Pagination for both projects and grantees
        $html .= "<script>
            $(document).ready(function () {

                function initPagination(wrapperSelector, linkSelector, prevSelector, nextSelector) {
                    var \$wrapper = $(wrapperSelector);
                    var \$links = \$wrapper.find(linkSelector);
                    var totalPages = \$links.length;

                    function getActivePage() {
                        return parseInt(\$wrapper.find(linkSelector + '.active').data('page')) || 1;
                    }

                    function setActivePage(page) {
                        \$links.removeClass('active');
                        \$wrapper.find(linkSelector + '[data-page=\"' + page + '\"]').addClass('active');
                    }

                    function showPagesFrom(page) {
                        \$links.hide();

                        for (var i = page; i <= page + 2; i++) {
                            \$wrapper.find(linkSelector + '[data-page=\"' + i + '\"]').show();
                        }

                        if (page <= 1) {
                            \$wrapper.find(prevSelector).addClass('disabled');
                        } else {
                            \$wrapper.find(prevSelector).removeClass('disabled');
                        }

                        if (page + 2 >= totalPages) {
                            \$wrapper.find(nextSelector).addClass('disabled');
                        } else {
                            \$wrapper.find(nextSelector).removeClass('disabled');
                        }
                    }

                    var visibleStartPage = getActivePage();
                    showPagesFrom(visibleStartPage);

                    \$wrapper.find(nextSelector).on('click', function () {
                        if ($(this).hasClass('disabled')) return;

                        visibleStartPage += 3;

                        if (visibleStartPage > totalPages) {
                            visibleStartPage = totalPages;
                        }

                        showPagesFrom(visibleStartPage);
                    });

                    \$wrapper.find(prevSelector).on('click', function () {
                        if ($(this).hasClass('disabled')) return;

                        visibleStartPage -= 3;

                        if (visibleStartPage < 1) {
                            visibleStartPage = 1;
                        }

                        showPagesFrom(visibleStartPage);
                    });

                    \$wrapper.find(linkSelector).on('click', function () {
                        var page = parseInt($(this).data('page'));
                        setActivePage(page);
                        visibleStartPage = page;
                        showPagesFrom(visibleStartPage);
                    });
                }

                initPagination('.pagination-wrapper-1', '.page-link-1', '.prev-1', '.next-1');
                initPagination('.pagination-wrapper-2', '.page-link-2', '.prev-2', '.next-2');

            });
        </script>";

        return $html;

    }

    public function getGrantees(Request $request){

        $page = $request->page;
        
        $granteesIds = $request->input('granteesIds', []);

        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $tmpGranteesIds = array_slice($granteesIds, $offset, $perPage);

        $grantees=Entries::WHEREIN('id',$tmpGranteesIds)->WHERE('published','1')->WHERENULL('deleted_at')->get();

        $title_position='top:15px;';
        $labels_position='bottom:15px;';

        $html="";
        if($grantees){
            $html.='<div class="collection" style="padding:0px;">
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
                                'button_text_arabic'=>@$button_text_arabic,
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

        return $html;

        // print_r($granteesIds);

    }


}
