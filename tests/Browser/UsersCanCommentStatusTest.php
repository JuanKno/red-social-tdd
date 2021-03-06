<?php

namespace Tests\Browser;

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
