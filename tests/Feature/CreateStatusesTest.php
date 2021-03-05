<?php

namespace Tests\Feature;

use App\Model\Status;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusesTest extends TestCase
{
    use RefreshDatabase;
    /**    
     * @test
     */
    public function guest_users_can_not_create_statuses()
    {

        $response = $this->postJson(route('status.store'), ['body' => 'My first status']);

        $response->assertStatus(401);
    }



    /**    
     * @test
     */
    public function an_authenticated_user_can_create_statuses()
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('status.store'), ['body' => $status->body]);

        $response->assertJson([
           'data' => ['body' => $status->body]
        ]);

        $this->assertDatabaseHas('statuses', ['body' => $status->body, 'user_id' => $user->id]);
    }

    /**    
     * @test
     */
    public function a_status_require_a_body()
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('status.store'), [
            'body' => ''
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /**    
     * @test
     */
    public function a_status_body_require_a_minimum_length()
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('status.store'), [
            'body' => 'adf'
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
