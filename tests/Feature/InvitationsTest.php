<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function non_owners_may_not_invite_users(){
        $this->actingAs(factory(User::class)->create())
            ->post(ProjectFactory::create()->path() . '/invitations')
            ->assertStatus(403);
    }

    public function a_project_owner_can_invite_a_user(){
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    public function the_email_address_must_be_associated_with_a_valid_birdboard_account(){
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations' . [
                'email' => 'The user you are inviting must have a Birdboard account'
            ]);
    }

    public function invited_users_may_update_project_details(){
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->signIn($newUser);

        $this->post(action('ProjectTaskController@store', $project), $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('task', $task);
    }
}
