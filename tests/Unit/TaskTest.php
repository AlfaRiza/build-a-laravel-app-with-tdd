<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_belongs_to_a_project(){
        $task = factory(Task::class)->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }

    /**
     * @test
     */
    public function it_has_a_path(){
        $task = factory(Task::class)->create();

        $task->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /**
     * @test
     */
    public function it_can_be_completed(){
        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);

        $task->completed();

        $this->assertTrue($task->fresh()->completed);
    }

    public function it_can_be_marked_as_incomplete(){
        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);

        $task->completed();

        $this->assertFalse($task->fresh()->completed);
    }




}
