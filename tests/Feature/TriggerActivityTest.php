<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function creating_a_project(){
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function(){
            $this->assertEquals('created_project', $activity->description);
        
            $this->assertNull($activity->changes);
        });
    }

    /**
     * @test
     */
    public function updating_a_project(){
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function(){
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed']
            ];
            $this->assertEquals($expected, $activity->changes);
        });

    }

    /**
     * @test
     */
    public function creating_task(){
        $project = ProjectFactory::create();

        $project->addTask('Some Task');

        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some Task', $activity->subject->body);
        });

    }
    /**
     * @test
     */
    public function completing_task(){
        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)->patch($project->task[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);
        // $project->addTask('Some Task');

        $this->assertCount(3, $project->activity);
        tap($project->activity->last(), function($activity){
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    public function incompleting_task(){
        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)->patch($project->task[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->task[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);

    }


    public function deleting_a_task(){
        $project = ProjectFactory::withTask(1)->create();

        $project->task[0]->delete();
        
        $this->assertCount(3, $project->activity);
    }
    
}