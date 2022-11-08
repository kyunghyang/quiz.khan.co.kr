<?php

namespace Tests\Feature\Pages;

use App\Models\Curation;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurationsIndexTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $other;

    protected $form;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->other = User::factory()->create();

        $this->actingAs($this->user);

        $this->form = [

        ];
    }

    /** @test */
    function 자신의_큐레이션목록을_조회할_수_있다()
    {
        $myCurations = Curation::factory()->count(5)->create([
            "user_id" => $this->user->id
        ]);

        $otherCurations = Curation::factory()->count(2)->create([
            "user_id" => $this->other->id
        ]);

        $this->get("/curations")->assertInertia(function ($page) use($myCurations){
            $items = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(count($myCurations), $items);
        });
    }
}
