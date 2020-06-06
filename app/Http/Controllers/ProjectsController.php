<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Request\UpdateProjectRequest;
use App\Project;

class ProjectsController extends Controller
{
    /**
     * index 
     */
    public function index(){
        $projects = auth()->user()->accessibleProjects();
        return view('projects.index', ['projects'   => $projects ]);
    }

    /**
     * show
     */
    public function show(Project $project){
        $this->authorize('update', $project);
        // if( auth()->user()->isNot($project->owner)){
        //     abort(403);
        // }
        return view('projects.show', ['project' => $project]);
    }

    /**
     * create
     */
    public function create(){
        return view('projects.create');
    }
    /**
     * store
     */
    public function store(){
        
        $project = auth()->user()->projects()->create($this->validateRequest());

        if(request()->wantsJson()){
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    /**
     * @edit
     */
    public function edit(Project $project){
        return view('projects.edit', compact('project'));
    }

    /**
     * update
     */
    public function update(Project $project){
        $this->authorize('update', $project);
        // if( auth()->user()->isNot($project->owner)){
        //     abort(403);
        // }
        // $attributes = request()->validate(['title' => 'required',
        //                                     'description' => 'required',
        //                                     'notes' => 'min:3'
        //                                     ]);
        // $request->persist();
        $project->update(
            $this->validateRequest()
        );

        return redirect($project->path());
    }

    public function validateRequest(){
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }

    public function destroy(Project $project){
        $this->authorize('manage', $project);
        $project->delete();

        return redirect('/projects');
    }


}
