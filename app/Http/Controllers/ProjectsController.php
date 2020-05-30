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
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * show
     */
    public function show(){
        $project = Project::findOrFail(request('project'));
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