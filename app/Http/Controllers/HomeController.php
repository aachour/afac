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

}
