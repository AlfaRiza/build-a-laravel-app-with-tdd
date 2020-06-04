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

        $this->recordActivity('completed_task');
    }

    public function incomplete(){
        $this->update(['completed' => false]);

        $this->project->recordActivity('incompleted_task');
    }
    
    public function project(){
        return $this->belongsTo(Project::class);
        $task->project->recordActivity('incompleted_task');
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function recordActivity($description){

        $this->activity()->create([
            'project_id' => $this->project_id,
            'description' => $description,
            
        ]);
    }



    public function activity(){
        return $this->morphMany(Activity::class, 'subject_id')->latest();
    }
}
