<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Collections;
use App\Models\Entries;

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

    public function ViewCollection($id){
        
        $collectionHTML = ViewCollection($id,'EN');       
        
        return view('frontend.collection', [
            'collectionHTML' => $collectionHTML
        ]);

    }


}
