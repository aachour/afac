<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entries;

class ProjectsController extends Controller
{
    
    public function projects()
    {

            
        //get all filters

        $projects=Entries::WHERE(['type_id'=>'3','published'=>'1'])->get();

        return view('frontend.projects');
    }

}
