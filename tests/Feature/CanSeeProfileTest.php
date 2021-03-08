<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanSeeProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_profile_test()
    {
        $this->withoutExceptionHandling();
        factory(User::class)->create(['name' => 'Juan']);

        $this->get('@Juan')->assertSee('Juan');
    }
}
