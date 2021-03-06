<?php

namespace App;
use Illuminate\Support\Arr;
trait RecordActivity {
    protected $oldAttributes = [];

    public function recordActivity($description){

        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner_id,
            'description' => $description,
            'changes' => $this->activityChanges($description),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
        
    }

    // public function activityOwner(){
    //     if(auth()->check()){
    //         return auth()->user();
    //     }

    //     if(class_basename($this) === 'Project'){
    //         return $this->owner_id;
    //     }

    //     return $this->project->owner_id;
    // }

    public static function bootRecordActivity(){


        // $recordableEvents = self::recordableEvents();

        foreach (self::recordableEvents() as $event ) {
            static::$event(function ($model) use ($event){
                $model->recordActivity($model->activityDescription($event));
            });
        }

        if($event === 'updated'){
            static::updating(function($model){
                $model->oldAttributes = $model->getOriginal();
            });
        }
    }

    public function activityDescription($description){
            return  "{$description}_" . strtolower(class_basename($this));
    }
    
    public function activity(){
        return $this->morphMany(Activity::class, 'subject_id')->latest();
    }

    public function activityChanges($description){
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()),'updated_at' ),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }

    protected static function recordableEvents(){
        if(isset(static::$recordableEvents)){
            return static::$recordableEvents;
            }           
                return ['created', 'updated', 'deleted'];
        // return $recordableEvents;
    }
}