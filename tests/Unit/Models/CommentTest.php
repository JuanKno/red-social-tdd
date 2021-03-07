<?php

namespace Tests\Unit\Models;

use App\Model\Comment;
use App\User;
use App\Traits\HasLikes;
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
    public function a_comment_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUsesTrait(HasLikes::class, Comment::class);
       
    }
}
