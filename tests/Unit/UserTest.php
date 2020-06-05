<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_user_has_projects(){
        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function a_user_has_accesible_projects(){
        $user = $this->signIn();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $sally = factory(User::class)->create();

        $nick = factory(User::class)->create();
        $sally = tap(ProjectFactory::ownedBy($sally)->create())->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());

        $sally->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
