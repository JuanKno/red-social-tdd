<?php

namespace Tests\Browser;

use App\Model\Comment;
use App\Model\Status;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function users_can_see_all_comments()
    {
        $status = factory(Status::class)->create();
        $comments = factory(Comment::class, 2)->create(['status_id' => $status->id]);

        $this->browse(function (Browser $browser) use ($comments, $status) {

            $browser->visit('/')
            ->waitForText($status->body)
            ->assertSee($comments->shift()->body)
            ->assertSee($comments->shift()->body)
            ;

        });
    }

    /**
     * @test
     */
    public function authenticated_users_can_comment_statuses()
    {

        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $comment = 'Mi primer comentario';
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->type('comment', $comment)
                ->press('@comment-btn')
                ->waitForText($comment)
                ->assertSee($comment);
        });
    }
}
