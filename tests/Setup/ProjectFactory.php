<?php

namespace Tests\Setup;

class ProjectFactory {

    protected $tasksCount = 0;
    protected $user;

    public function withTasks($count){
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy(){
        $this->user = $user;

        return $this;
    }


    public function create(){
        
        $project = factory(Project::class)->create([
            'owner_id' => $user ?? factory(User::class)
        ]);

        factory(Task::class, $this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;

    }

}

// app(ProjectFactory::class)->create();