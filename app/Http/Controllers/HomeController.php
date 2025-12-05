<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        
        $pageSections=PageSections::WHERE('page_id',$id)->ORDERBY('list_order','ASC')->get();

        $pageHTML='';

        foreach($pageSections as $pageSection){
            if($pageSection->section_id){
                $pageHTML.= ViewSection($id,'EN');  
            }
            else if($pageSection->collection_id){
                $pageHTML.= ViewCollection($id,'EN');
            }
        }

        return view('frontend.page', [
            'pageHTML' => $pageHTML
        ]);

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


}
