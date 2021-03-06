<?php

namespace Tests\Unit\Models;

use App\Model\Comment;
use App\Model\Like;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_comment_belongs_to_user()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }


    /**
     *@test
     */
    public function a_comment_morph_many_likes()
    {
        $comment = factory(Comment::class)->create();

        factory(Like::class)->create([
            'likeable_id' =>  $comment->id,          // 1
            'likeable_type' =>  get_class($comment), //App/Model/Comment
        ]);

        $this->assertInstanceOf(Like::class, $comment->likes->first());
    }

    /**
     *@test
     */
    public function a_comment_can_be_liked_and_unliked()
    {
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $comment->like();
        $this->assertEquals(1, $comment->fresh()->likes->count());

        $comment->unLike();
        $this->assertEquals(0, $comment->fresh()->likes->count());
    }

    /**
     *@test
     */
    public function a_comment_can_be_liked_once()
    {
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $comment->like();

        $this->assertEquals(1, $comment->likes->count());

        $comment->like();

        $this->assertEquals(1, $comment->fresh()->likes->count());
    }

    /**
     *@test
     */

    public function a_comment_knows_if_it_has_been_liked()
    {
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();
        $this->assertFalse($comment->isLiked());

        $this->actingAs($user);
        $this->assertFalse($comment->isLiked());

        $comment->like();
        $this->assertTrue($comment->isLiked());
    }

    /**
     *@test
     */

    public function a_comment_knows_how_many_likes_it_has()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals(0, $comment->likesCount());

        factory(Like::class, 2)->create([
            'likeable_id' =>  $comment->id,          // 1
            'likeable_type' =>  get_class($comment), //App/Model/Status
            'created_at' => now()->subMinute()
        ]);

        $this->assertEquals(2, $comment->likesCount());
    }
}
