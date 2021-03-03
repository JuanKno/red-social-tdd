<?php

namespace Tests\Feature;

use App\Model\Status;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeStatusesTest extends TestCase
{

    use RefreshDatabase;


    /**    
     * @test
     */
    public function guest_users_can_not_like_statuses()
    {
        // $this->withoutExceptionHandling();

        $status = factory(Status::class)->create();

        $response = $this->post(route('statuses.likes.store', $status));

        $response->assertRedirect('login');
    }

    /**    
     * @test
     */
    public function an_authenticated_user_can_like_statuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->actingAs($user);
        $this->postJson(route('statuses.likes.store', $status));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'status_id' => $status->id,
        ]);
    }

    /**    
     * @test
     */
    public function an_authenticated_user_can_unlike_statuses()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->actingAs($user);
        $this->postJson(route('statuses.likes.store', $status));

        $this->deleteJson(route('statuses.likes.destroy', $status));



        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'status_id' => $status->id,
        ]);
    }
}
