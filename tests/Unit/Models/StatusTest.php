<?php

namespace Tests\Unit\Models;

use App\User;
use App\Model\Status;
use App\Model\Like;
use App\Model\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_status_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();

        $this->assertInstanceOf(User::class, $status->user);
    }


    /**
     *@test
     */
    public function a_status_has_many_likes()
    {

        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        factory(Like::class)->create(['status_id' =>  $status->id]);

        $this->assertInstanceOf(Like::class, $status->likes->first());
    }

      /**
     *@test
     */
    public function a_status_has_many_comments()
    {

        $status = factory(Status::class)->create();

        factory(Comment::class)->create(['status_id' =>  $status->id]);

        $this->assertInstanceOf(Comment::class, $status->comments->first());
    }


    /**
     *@test
     */
    public function a_status_can_be_liked_and_unliked()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $status->like();
        $this->assertEquals(1, $status->fresh()->likes->count());

        $status->unLike();
        $this->assertEquals(0, $status->fresh()->likes->count());
    }

    /**
     *@test
     */
    public function a_status_can_be_liked_once()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $status->like();

        $this->assertEquals(1, $status->likes->count());

        $status->like();

        $this->assertEquals(1, $status->fresh()->likes->count());
    }

    /**
     *@test
     */

    public function a_status_knows_if_it_has_been_liked()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $this->assertFalse($status->isLiked());

        $this->actingAs($user);
        $this->assertFalse($status->isLiked());

        $status->like();
        $this->assertTrue($status->isLiked());
    }

    /**
     *@test
     */

    public function a_status_knows_how_many_likes_it_has()
    {
        $status = factory(Status::class)->create();
        $this->assertEquals(0, $status->likesCount());

        factory(Like::class, 2)
            ->create(['status_id' =>  $status->id, 'created_at' => now()->subMinute()]);

        $this->assertEquals(2, $status->likesCount());
    }
}
