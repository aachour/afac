<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entries;

class ProjectsController extends Controller
{
    
    public function projects()
    {
            
        //get all filters

        $projects = Entries::where([
            'type_id'   => 3,
            'published' => 1
        ])->get(['id', 'project_categories_id', 'project_countries_id']);

        $projects_ids = $projects->pluck('id')->toArray();

        $projects_categories_ids = $projects
            ->pluck('project_categories_id')
            ->filter()
            ->flatMap(fn($item) => explode(',', $item))
            ->unique()
            ->values()
            ->toArray();

        $projects_countries_ids = $projects
            ->pluck('project_countries_id')
            ->filter()
            ->flatMap(fn($item) => explode(',', $item))
            ->unique()
            ->values()
            ->toArray();

        dd($projects_ids,$projects_categories_ids,$projects_countries_ids);

        return view('frontend.projects');
    }

}
