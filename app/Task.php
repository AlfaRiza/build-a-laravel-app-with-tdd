<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Providers\Task;
class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];


    public function complete(){
        $this->update(['completed' => true]);

        $task->project->recordActivity('completed_task');
    }

    public function incomplete(){
        $this->update(['completed' => false]);

        $task->project->recordActivity('completed_task');
    }
    
    public function project(){
        return $this->belongsTo(Project::class);
        $task->project->recordActivity('incompleted_task');
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
