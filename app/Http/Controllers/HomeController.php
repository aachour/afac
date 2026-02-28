<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Pages;
use App\Models\Entries;
use App\Models\PageSections;

use App\Models\Contacts;
use App\Models\Subscribers;

use App\Models\Collections;
use App\Models\CollectionEntries;
use App\Models\Sections;
use App\Models\SectionColumns;
use App\Models\ColumnGeneral;
use App\Models\ColumnTimeline;
use App\Models\ColumnAccordion;
use App\Models\ColumnCountdown;
use App\Models\ColumnExpandTexts;
use App\Models\ProjectGrantees;
use App\Models\ProgramYearProjects;
use App\Models\ProgramYearJurors;
use App\Models\ProgramYears;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class HomeController extends Controller
{
    
    public function home()
    {
        return view('frontend.home');
    }


    public function ViewPage($id){
        
        $page=Pages::find($id);

        if($page)
        {

            $headerBgCode=$page->headerBgColor->code;
            $footerBgCode=$page->footerBgColor->code;
            
            $pageSections=PageSections::WHERE('page_id',$id)->ORDERBY('list_order','ASC')->get();

            $pageHTML='';

            foreach($pageSections as $pageSection){
                if($pageSection->section_id){
                    $pageHTML.= ViewSection($pageSection->section_id,'EN');  
                }
                else if($pageSection->collection_id){
                    $pageHTML.= ViewCollection($pageSection->collection_id,'EN');
                }
            }

            return view('frontend.page', [
                'pageHTML' => $pageHTML,
                'headerBgCode'=>$headerBgCode,
                'footerBgCode'=>$footerBgCode,
            ]);
        }
        else
        {
            dd("!!");
        }

    }


    public function ViewEntry($entryType,$id){
        
        $entry=Entries::find($id);

        if($entry)
        {

            $headerBgCode=$entry->headerBgColor->code ?? '';
            $footerBgCode=$entry->footerBgColor->code ?? '';
            
            $pageSections=PageSections::WHERE('entry_id',$id)->ORDERBY('list_order','ASC')->get();
            
            $pageHTML='';

            $pageHTML.= ViewEntryData($id,'EN'); 

            foreach($pageSections as $pageSection){
                if($pageSection->section_id){
                    $pageHTML.= ViewSection($pageSection->section_id,'EN');  
                }
                else if($pageSection->collection_id){
                    $pageHTML.= ViewCollection($pageSection->collection_id,'EN');
                }
            }

            return view('frontend.page', [
                'pageHTML' => $pageHTML,
                'headerBgCode'=>$headerBgCode,
                'footerBgCode'=>$footerBgCode,
            ]);
        }
        else
        {
            dd("!!");
        }

    }


    public function ViewCollection($id){
        
        $collectionHTML = ViewCollection($id,'EN');       
        
        return view('frontend.collection', [
            'collectionHTML' => $collectionHTML
        ]);

    }


    public function ViewSection($id){
        
        $sectionHTML = ViewSection($id,'EN');       
        
        return view('frontend.section', [
            'sectionHTML' => $sectionHTML
        ]);

    }


    public function animation()
    {
        return view('frontend.animation');
    }


    public function viewLogo(){

        $logoElements=getLogoActiveElements();
 
        return view('frontend.logo', [
            'logoElements' => $logoElements
        ]);
        
    }


    public function getFilteredEntries(Request $request){
        
        $collection_id = $request->collection_id;
        $entries_id = explode(",",$request->entries_id ?? []);
        $filters = $request->filters;
        
        $collection=Collections::find($collection_id);

        if($collection==null){
            return '';
        }
        
        $collection_type_id=$collection->type_id;
        $calendar_view=$collection->calendar_view;
        $show_name=$collection->show_name;
        $show_description=$collection->show_description;
        $show_view_all=$collection->show_view_all;
        $show_projects_grantees=$collection->show_projects_grantees;
        $view_all_title=$collection->view_all_title;
        $view_all_link=$collection->view_all_link;
        $button_text=$collection->button_text;
        $button_bg_color=$collection->buttonBgColor?->code;
        $entries_selection=$collection->entries_selection;
        $entries_per_row=$collection->entries_per_row;
        $entries_layout=$collection->entries_layout;
        $with_filters=$collection->with_filters;
        $with_label=$collection->with_label;
        $with_featured=$collection->with_featured_image;
        $all_featured=$collection->all_featured;

        $featured_image_width=$collection->featured_image_width;

        $featured_width=0;
        $featured_margin=0;
        if($featured_image_width==1) //full
        {
            $featured_width='100%';
            $featured_margin='0%';
        }
        else if($featured_image_width==2) //three quarter
        {
            $featured_width='74.3%';
            $featured_margin='25.6%';
        }

        $featured_image_bgColor = $collection->featuredImageBgColor?->code ?? '#ffffff'; 

        $title_position='top:15px;';
        $labels_position='bottom:15px;';

        if($collection->title_position=='1')
        {
            $title_position='bottom:15px;';
            $labels_position='top:15px;';
        }
        
        //Get All Entries with filters
        /*if (!is_array($entries_id)) {
            $entries_id = json_decode($entries_id, true) ?? [];
        }*/

        // $entries_id=[];
        $entries=buildEntriesQuery($collection_id,$filters,$entries_id);

        echo count($entries);

        $html="";

        //Set toggle show project grantees
        if($collection_type_id==3 && $show_projects_grantees==1){
            $html.='<div class="toggleContainer" >
                <label class="pill-toggle">
                    <input type="checkbox" id="granteesToggle">

                    <span class="pill">
                        <span class="knob"></span>
                        <span class="text">Grantees View</span>
                    </span>
                </label>
            </div>';
        }

        //Show Calendar View
        if($collection_type_id==1 && $calendar_view==1)
        {

            $events=[];

            foreach($entries as $entry){
                $obj=[
                    'id'=>$entry->id,
                    'event_start_date'=>$entry->event_start_date,
                    'event_end_date'=>$entry->event_end_date,
                ];
                $events [] = $obj;
            }  

            $datesEvents = [];
            $monthCounters = [];

            foreach ($events as $event) {
                $monthKey = date('Y-m', strtotime($event['event_start_date']));

                if (!isset($monthCounters[$monthKey])) {
                    $monthCounters[$monthKey] = 0;
                }

                if ($monthCounters[$monthKey] < 3) {
                    $datesEvents[$monthKey][] = $event;
                    $monthCounters[$monthKey]++;
                }
            }

            $html.='<div class="collection '.$sliderCollection.' '.($bgColor ? 'mt-3' : '').'" style="background-color:'.$bgColor.';">';
                
                foreach($datesEvents as $date=>$dateEvents){

                    $html.='<div class="entries">
                            
                        <div class="entry">
                            <div class="big black ABCDiatypeMedium">'.date('M Y',strtotime($date)).'</div>
                        </div>';

                        foreach($dateEvents as $event){

                            $image_path = asset('frontend/images/default-image.png');
                            if (!empty($entry->image)) {
                                $image_path = asset('storage/' . $entry->image);
                            }

                            //get entry details
                            $entryDetails=getEntryDetails($collection_type_id,$entry);
                            $entry_title=$entryDetails["entry_title"];
                            $entry_text=$entryDetails["entry_text"];
                            $entry_href=$entryDetails["entry_href"];
                            $entry_target=$entryDetails["entry_target"];

                            $html.='<div class="swiper-slide entry">';

                                $labels=getEntryLabels($entry);

                                $html .= view('frontend.entry-hover-animation', [
                                    'collection_type_id'=>$collection_type_id,
                                    'entry_href'=>$entry_href,
                                    'entry_target'=>$entry_target,
                                    'image_path'=>$image_path,
                                    'entry_title' => $entry_title,
                                    'entry_text' => $entry_text,
                                    'title_position'=>$title_position,
                                    'with_label' => $with_label,
                                    'labels_position'=>$labels_position,
                                    'entry_type_name' => $entry->type->name,
                                    'collection_type_id' => $collection_type_id,
                                    'labels' => $labels,
                                    'button_text'=>$button_text,
                                    'button_bg_color'=>$button_bg_color,
                                    'featured'=>'0',
                                ])->render();
                                                                    
                            $html .='</div>';

                        }
                            
                        $html.='<div class="clear"></div>';

                    $html.='</div>';

                }

            $html.='</div>';
            
        }
        else
        {
            
            if(count($entries)>0)
            {

                //show featured entry on top
                if($with_featured==1) 
                { 

                    foreach($entries as $key=>$entry){
                        
                        $image_path = asset('frontend/images/default-image-featured.png');
                        if (!empty($entry->image)) {
                            $image_path = asset('storage/' . $entry->image_featured);
                        }

                        //get entry details
                        $entryDetails=getEntryDetails($collection_type_id,$entry);
                        $entry_title=$entryDetails["entry_title"];
                        $entry_text=$entryDetails["entry_text"];
                        $entry_href=$entryDetails["entry_href"];
                        $entry_target=$entryDetails["entry_target"];

                        //desktop view
                        $html.='<a href="'.$entry_href.'" target="'.$entry_target.'">
                            <div class="desktopOnly">';
                                if( ($show_name==1 || $show_view_all==1) && $featured_width=='74.3%' && $key==0){
                                    $html.='<div class="featured_title_view_all">';
                                        if($show_name==1){
                                            $html.='<div class="black big ABCDiatypeMedium">'.$collection->name.'</div>';
                                        }
                                        if($show_view_all==1){
                                            $html.='<div class="topSpacerSmaller">
                                                <a href="'.$view_all_link.'" class="black tiny ABCDiatypeBlack">'.$view_all_title.' &nbsp;<img src="'.asset('frontend/images/view-all-btn-en.png').'" width="9px" style="margin-top:5px;"></a>
                                            </div>';
                                        }
                                    $html.='</div>';
                                }
                                $html.='<div class="topSpacer featured_entry" style="background:'.$featured_image_bgColor.'; width:'.$featured_width.'; margin-left:'.$featured_margin.';">';
                                    $html.='<div class="featured_info">
                                        <div class="title_or_labels" style="'.$title_position.'">
                                            <div class="medium white ABCDiatypeMedium">'.$entry_title.'</div>
                                            <div class="topSpacerSmall tiny white threeQuartersText">'.mb_substr($entry_text,0,350).'...</div>';
                                        $html.='</div>';

                                        if($with_label==1)
                                        {
                                            $labels=getEntryLabels($entry);
                                            $html.='<div class="title_or_labels threeQuartersText" style="'.$labels_position.'">
                                                <div class="label micro ABCDiatypeMedium">'.$entry->type->name.'</div>
                                                <div class="label micro rounded ABCDiatypeMedium">'.@$labels[0].'</div>
                                                <div class="label micro rounded ABCDiatypeMedium">'.@$labels[1].' - '.@$labels[2].'</div>
                                                <div class="clear">&nbsp;</div>
                                            </div>';
                                        }
                                    $html.='</div>
                                    <div class="featured_image">';
                                        $html .= view('frontend.entry-hover-animation', [
                                            'collection_type_id'=>$collection_type_id,
                                            'entry_text'=>$entry_text,
                                            'image_path'=>$image_path,
                                            'entry_href'=>$entry_href,
                                            'entry_target'=>$entry_target,
                                            'button_text'=>$button_text,
                                            'button_bg_color'=>$button_bg_color,
                                            'featured'=>'1',
                                            ])->render();
                                    $html.='</div>
                                </div>
                            </div>
                        </a>';
                        
                        //mobile view
                        $html.='<a href="'.$entry_href.'" target="'.$entry_target.'">
                            <div class="entries mobileOnly">';
                                if( ($show_name==1 || $show_view_all==1) && $featured_width=='74.3%' && $key==0){
                                    if($show_name==1){
                                        $html.='<div class="black big ABCDiatypeMedium">'.$collection->name.'</div>';
                                    }
                                    if($show_view_all==1){
                                        $html.='<div class="topSpacerSmaller">
                                            <a href="'.$view_all_link.'" class="black tiny ABCDiatypeBlack">'.$view_all_title.' &nbsp;<img src="'.asset('frontend/images/view-all-btn-en.png').'" width="9px" style="margin-top:5px;"></a>
                                        </div>';
                                    }
                                }
                                $html.='<div class="featured_entry_mobile" style="background:'.$featured_image_bgColor.';">
                                    <img src="'.$image_path.'" width="100%" />
                                    <div class="description">
                                        <div class="title_or_labels medium white ABCDiatypeMedium" style="'.$title_position.'">'.$entry_title.'</div>';
                                        if($with_label==1)
                                        {
                                            $html.='<div class="title_or_labels" style="'.$labels_position.'">
                                                <div class="label micro black ABCDiatypeMedium">'.$entries[0]->type->name.'</div>';
                                                $labels=getEntryLabels($entry);
                                                $html.='<div class="title_or_labels threeQuartersText" style="'.$labels_position.'">
                                                    <div class="label micro ABCDiatypeMedium">'.$entry->type->name.'</div>
                                                    <div class="label micro rounded ABCDiatypeMedium">'.@$labels[0].'</div>
                                                    <div class="label micro rounded ABCDiatypeMedium">'.@$labels[1].' - '.@$labels[2].'</div>
                                                    <div class="clear">&nbsp;</div>
                                                </div>
                                            </div>';
                                        }
                                    $html.='</div>
                                </div>
                            </div>
                        </a>';

                        if($all_featured==0)
                        {
                            break; 
                        }  
                    }
                                        
                }

                if($all_featured==0 || $all_featured==null)
                { 

                    $html.='<div class="entries">';
                        
                        $entries_count=0;

                        if($entries_layout==1 && $entries_per_row==4){
                            $html.='
                            <style>
                                @media(min-width:900px){
                                    .collection .entries > .entry:nth-child(4n of .entry){
                                        margin-right:0 !important;
                                    }
                                }
                            </style>';
                        }

                        //Open slider
                        if($entries_layout==2) 
                        {

                            $html.='<style>
                                .sliderCollection .entries .entry:nth-child(4n){
                                    margin-right:1.2% !important;
                                }
                            </style>';

                            $html.='<div class="swiper" id="swiper'.$collection_id.'" style="width:102.5%; padding-bottom:15px;">
                                <div class="swiper-wrapper">';
                        }

                        //Fetch all entries
                        foreach($entries as $key=>$entry)
                        {

                            if ($with_featured==1 && $key ==0) {
                                continue; // skip first
                            }

                            $image_path = asset('frontend/images/default-image.png');
                            if (!empty($entry->image)) {
                                $image_path = asset('storage/' . $entry->image);
                            }

                            //get entry details
                            $entryDetails=getEntryDetails($collection_type_id,$entry);
                            $entry_title=$entryDetails["entry_title"];
                            $entry_text=$entryDetails["entry_text"];
                            $entry_href=$entryDetails["entry_href"];
                            $entry_target=$entryDetails["entry_target"];

                            $html.='<div class="swiper-slide entry">';

                                $labels=getEntryLabels($entry);

                                $html .= view('frontend.entry-hover-animation', [
                                    'collection_type_id'=>$collection_type_id,
                                    'entry_href'=>$entry_href,
                                    'entry_target'=>$entry_target,
                                    'image_path'=>$image_path,
                                    'entry_title' => $entry_title,
                                    'entry_text' => $entry_text,
                                    'title_position'=>$title_position,
                                    'with_label' => $with_label,
                                    'labels_position'=>$labels_position,
                                    'entry_type_name' => $entry->type->name,
                                    'collection_type_id' => $collection_type_id,
                                    'labels' => $labels,
                                    'button_text'=>$button_text,
                                    'button_bg_color'=>$button_bg_color,
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

                            //check entries per row
                            $entries_count++;

                            if($entries_layout==1 && $entries_count % $entries_per_row==0){
                                $html.='<div class="clear">&nbsp;</div>';
                            }

                        }

                        $html.='<div class="clear"></div>';
                        
                        //Close Slider
                        if($entries_layout==2) 
                        {
                                $html.='</div>                             
                            </div>

                            <!-- Navigation buttons --> 
                            <div class="mt-4">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>';
                        }

                    $html.='</div>';
                }

            }
            else{
                $html.='<div class="mt-3 small black ABCDiatypeMedium text-start">No results to display for your selected filters </div>';
            }
        
            //add swiper JS 
            $html.='<script> 
                if($("#swiper'.$collection_id.'").length>0){
                    const swiper'.$collection_id.' = new Swiper("#swiper'.$collection_id.'", {
                        //loop: true,
                        grid: {
                            rows: 1           
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        /*autoplay: {
                            delay: 2500,
                            disableOnInteraction: false,
                        },*/
                        effect: "slide",
                        speed: 800,
                        breakpoints: {
                            // when window width is >= 320px
                            576: {
                                slidesPerView: 0.85,
                                spaceBetween: 0
                            },
                            // when window width is >= 992px
                            900: {
                                slidesPerView: 4.1,
                                spaceBetween: 20
                            },
                        }
                    });
                }
            </script>';
        }

        //get all grantees related to collection of type projects.
        /*if($collection_type_id==3 && $show_projects_grantees==1){

            $projectIds=CollectionEntries::WHERE('collection_id',$collection_id)->pluck('entry_id')->toArray();
            $granteeIds=ProjectGrantees::WHEREIN('project_id',$projectIds)->pluck('grantee_id')->toArray();
            $grantees=Entries::WHERE('published',1)->WHEREIN('id',$granteeIds)->get();
            if($grantees){
                $html.='<div class="collection d-none" id="projectGrantees" style="padding-top:0px; background-color:'.$bgColor.';">
                    <div class="entries">';
                                
                        $entries_count=0;

                        //Fetch all entries
                        foreach($grantees as $key=>$entry)
                        {

                            if ($with_featured==1 && $key ==0) {
                                continue; // skip first
                            }

                            $image_path = asset('frontend/images/default-image.png');
                            if (!empty($entry->image)) {
                                $image_path = asset('storage/' . $entry->image);
                            }

                            //get entry details
                            $entryDetails=getEntryDetails($entry->type_id,$entry);
                            $entry_title=$entryDetails["entry_title"];
                            $entry_text=$entryDetails["entry_text"];
                            $entry_href=$entryDetails["entry_href"];
                            $entry_target=$entryDetails["entry_target"];

                            $html.='<div class="swiper-slide entry">';

                                $labels=getEntryLabels($entry);

                                $html .= view('frontend.entry-hover-animation', [
                                    'collection_type_id'=>$entry->type_id,
                                    'entry_href'=>$entry_href,
                                    'entry_target'=>$entry_target,
                                    'image_path'=>$image_path,
                                    'entry_title' => $entry_title,
                                    'entry_text' => $entry_text,
                                    'title_position'=>$title_position,
                                    'with_label' => $with_label,
                                    'labels_position'=>$labels_position,
                                    'entry_type_name' => $entry->type->name,
                                    'collection_type_id' => $collection_type_id,
                                    'labels' => $labels,
                                    'button_text'=>$button_text,
                                    'button_bg_color'=>$button_bg_color,
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

                            if($entries_layout==1 && $entries_count % $entries_per_row==0){
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
                            $("#projectGrantees").removeClass("d-none");
                        } 
                        else{
                            $("#projectGrantees").addClass("d-none");
                        }
                    });
                });
            </script>';
            
        }*/
    
        return $html;
        
    }


}
