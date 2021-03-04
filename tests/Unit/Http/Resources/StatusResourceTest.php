<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\StatusResource;
use App\Model\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_status_resource_must_have_the_necessary_fields()
    {
        $status = factory(Status::class)->create();

        $statusResource = StatusResource::make($status)->resolve();

        $this->assertEquals(
            $status->id,
            $statusResource['id']
        );
        $this->assertEquals(
            $status->body,
            $statusResource['body']
        );
        $this->assertEquals(
            $status->user->name,
            $statusResource['user_name']
        );
        $this->assertEquals(
            'https://www.beahero.gg/wp-content/uploads/2019/07/Re-Zero-Rem.jpg',
            $statusResource['user_avatar']
        );
        $this->assertEquals(
            $status->created_at->diffForHumans(),
            $statusResource['ago']
        );
        $this->assertEquals(
            false,
            $statusResource['is_liked']
        );
        $this->assertEquals(
            0,
            $statusResource['likes_count']
        );
    }
}
