<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use App\RecordActivity;

class Project extends Model
{

    // use TriggersActivity;
    use RecordActivity;

    protected $guarded = [];


    public function path(){
        return "/projects/{$this->id}";
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    // public function recordActivity($description){

    //     $this->activity()->create([
    //         'description' => $description,
    //         'changes' => $this->activityChanges($description),
    //         'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
    //     ]);
        
    // }

    // public function activityChanges($description){
    //     if ($this->wasChanged()) {
    //         return [
    //             'before' => Arr::except(array_diff($this->old, $this->getAttributes()),'updated_at' ),
    //             'after' => Arr::except($this->getChanges(), 'updated_at'),
    //         ];
    //     }
    // }

    public function addTask($body){
        return $this->tasks()->create(compact('body'));
    }
    public function addTasks($tasks){

        return $this->tasks()->createtoMany($tasks);
    }

    public function activity(){
        return $this->hasMany(Activity::class)->latest();
    }


    public function invite(User $user){
        return $this->members()->attach($user);
    }

    public function members(){
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }
    
}
