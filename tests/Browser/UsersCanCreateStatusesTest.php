<?php

namespace Tests\Browser;

use App\Model\Status;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanCreateStatuses extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function users_can_create_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create(['created_at' => now()->subMinute()]);

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                ->visit('/')
                ->type('body', $status->body)
                ->press('#create-status')
                ->waitForText($status->body)
                ->assertSee($status->body);
        });
    }
}
