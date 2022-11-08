<?php

namespace Tests\Feature\Pages;

use App\Models\PointHistory;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnswersCreateTest extends TestCase
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
    function 사용자는_오늘의_퀴즈목록을_조회할_수_있다()
    {
        $openQuestions = Question::factory()->count(3)->create([
            "opened_at" => Carbon::today()
        ]);

        $notOpenQuestions = Question::factory()->count(5)->create([
            "opened_at" => Carbon::yesterday()
        ]);

        $this->get("/answers/create")->assertInertia(function ($page) use($openQuestions){
            $items = $page->toArray()["props"]["questions"]["data"];

            $this->assertCount(count($openQuestions), $items);
        });
    }

}
