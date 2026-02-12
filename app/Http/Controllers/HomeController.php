<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Pages;
use App\Models\Entries;
use App\Models\PageSections;

use App\Models\Contacts;
use App\Models\Subscribers;

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


    public function getEntries(Request $request){
        
        $collection_id = $request->collection_id;
        $entries_layout = $request->entries_layout;
        $entries_per_row = $request->entries_per_row;
        $entries = $request->entries;

        foreach($entries as $key=>$entry){
            return $entry["id "];
        }
        
        $html="";

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

        return $html;
        
    }


}
