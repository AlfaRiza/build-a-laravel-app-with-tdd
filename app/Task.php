<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Providers\Task;
class Task extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $recordableEvents = ['created','deleted'];


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

    // public function recordActivity($description){

    //     $this->activity()->create([
    //         'description' => $description,
    //         'changes' => $this->activityChanges($description),
    //         'project_id' => $this->project_id,
            
    //     ]);
    // }

    // public function activityChanges($description){
    //     // return null;
    //     if ($this->wasChanged()) {
    //         return [
    //             'before' => Arr::except(array_diff($this->old, $this->getAttributes()),'updated_at' ),
    //             'after' => Arr::except($this->getChanges(), 'updated_at'),
    //         ];
    //     }
    // }


}
