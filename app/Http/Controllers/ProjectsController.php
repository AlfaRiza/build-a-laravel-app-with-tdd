<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    /**
     * index 
     */
    public function index(){
        $projects = auth()->user()->projects;
        return view('projects.index', ['projects'   => $projects ]);
    }

    /**
     * show
     */
    public function show(Project $project){
        if( auth()->user()->isNot($project->owner)){
            abort(403);
        }
        return view('projects.show', ['project' => $project]);
    }

    /**
     * store
     */
    public function store(){
        $attributes = request()->validate(['title' => 'required',
                                            'description' => 'required',
                                            ]);

        auth()->user()->projects()->create($attributes);

        return redirect('/projects');
    }


}
