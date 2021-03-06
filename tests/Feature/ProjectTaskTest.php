<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use App\Project;

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

        $project = ProjectFactory::withTasks(1)->create();

        // $project = factory('App\Project')->create();

        $task = $project->addTask('Task Test');

        $this->patch($project->tasks[0]->path(), ['body' => 'Changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);

    }
    /**
     * @test
     */
    public function a_project_can_have_tasks(){
        // $this->withoutExceptionHandling();
        // $this->signIn();

        // $project = auth()->user()->projects()->create(
        //     factory(Project::class)->raw()
        // );

        $project = ProjectFactory::create();


        $this->actingAs($project->owner)
        ->post($project->path() . '/tasks', ['body' => 'Test Task']);

        $this->get($project->path())
            ->assertSee('Test Task');
    }

    /**
     * @test
     */
    function a_task_can_be_updated(){
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    function a_task_can_be_completed(){
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    function a_task_can_be_marked_as_incomplete(){

        $this->withoutErrorHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }
    
    /**
     * @test
     */
    public function a_task_requires_a_body(){
        // $this->signIn();

        // $project = auth()->user()->projects()->create(
        //     factory(Project::class)->raw()
        // );

        $project = ProjectFactory::create();

        $attributes = factory('App\Task')->raw([
            'body' => ''
        ]);
        $this->actingAs($project->owner)
        ->post($project->path() . '/tasks', $attributes)
        ->assertSessionHasErrors('body');
    }
}
