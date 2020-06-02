<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_has_a_path(){
        $project = factory('App\Project')->create();
        $this->assertEquals('/projects/'. $project->id, $project->path());
    }

    public function it_belongs_to_an_owner(){
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }

    public function it_can_add_a_task(){
        $project = factory('App\Project')->create();

        $project->addTask('Test Task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
