<?php

namespace App\Observers;

// use App\Providers\ProjectObserver;
use App\Project;
use App\Task;
use App\Activity;

class ProjectObserver
{
    public function created(Project $project){
        $project->recordActivity( 'created');
    }

    public function updated(Project $project){
        $project->recordActivity('updated');
    }

    
}
