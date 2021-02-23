<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @test
     */
    public function registered_users_can_login()
    {
        $user = factory(User::class)->create(['email' => 'prueba@prueba.com']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', 'prueba@prueba.com')
                ->type('password', 'secret')
                ->press('#login-btn')
                ->assertAuthenticated();
        });
    }
}
