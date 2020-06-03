<?php

namespace App\Observers;

use App\Project;
use App\Activity;

class ProjectObserver
{
    public function created(Project $project){
        $this->recordActivity($project, 'created');
    }

    public function updated(Project $project){
        $this->recordActivity($project, 'updated');
    }

    public function recordActivity($project, $type){
        Activity::create([
            'project_id' => $Project->id,
            'description' => $type,
        ]);
    }
}
