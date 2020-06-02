<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function guests_cannot_add_tasks_to_projects(){
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }
    /**
     * @test
     */
    function adding_a_task_if_you_are_not_the_project_owner(){
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test Task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test Tas']);

    }
    /**
     * @test
     */
    function only_the_owner_of_a_project_may_update_tasks(){
        $this->signIn();

        $project = factory('App\Project')->create();

        $task = $project->addTask('Task Test');

        $this->patch($task->path(), ['body' => 'Changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);

    }
    /**
     * @test
     */
    public function a_project_can_have_tasks(){
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );


        $this->post($project->path() . '/tasks', ['body' => 'Test Task']);

        $this->get($project->path())
            ->assertSee('Test Task');
    }

    /**
     * @test
     */
    function a_task_can_be_updated(){
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('Test Task');

        $this->patch($project->path() . '/tasks' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }
    
    /**
     * @test
     */
    public function a_task_requires_a_body(){
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory('App\Task')->raw([
            'body' => ''
        ]);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
