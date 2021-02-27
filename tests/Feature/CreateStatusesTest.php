<?php

namespace Tests\Feature;

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
        // $this->withoutExceptionHandling();

        $response = $this->post(route('status.store'), [
            'body' => 'My first status'
        ]);

        $response->assertRedirect('login');
    }



    /**    
     * @test
     */
    public function an_authenticated_user_can_create_statuses()
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('status.store'), ['body' => 'My first status']);

        $response->assertJson([
           'data' => ['body' => 'My first status']
        ]);

        $this->assertDatabaseHas('statuses', ['body' => 'My first status', 'user_id' => $user->id]);
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
