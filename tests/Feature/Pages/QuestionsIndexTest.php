<?php

namespace Tests\Feature\Pages;

use App\Models\Answer;
use App\Models\Curation;
use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionsIndexTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $other;

    protected $form;

    protected $correctQuestions;

    protected $incorrectQuestions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->other = User::factory()->create();

        $this->actingAs($this->user);

        $this->correctQuestions = Question::factory()->count(3)->create();

        foreach($this->correctQuestions as $question){
            $option = Option::factory()->create([
                "question_id" => $question->id,
                "correct" => 1
            ]);

            Answer::factory()->create([
                "option_id" => $option->id,
                'question_id' => $question->id,
                "user_id" => $this->user->id
            ]);
        }

        $this->incorrectQuestions = Question::factory()->count(3)->create();

        foreach($this->incorrectQuestions as $question){
            $option = Option::factory()->create([
                "question_id" => $question->id,
                "correct" => 0
            ]);

            Answer::factory()->create([
                "option_id" => $option->id,
                'question_id' => $question->id,
                "user_id" => $this->user->id
            ]);
        }

        $this->form = [

        ];
    }

    /** @test */
    function 자신이_참여한_퀴즈목록을_조회할_수_있다()
    {
        $notParticipateQuestions = Question::factory()->count(5)->create();

        $this->get("/questions")->assertInertia(function ($page){
            $items = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(count($this->incorrectQuestions) + count($this->correctQuestions), $items);
        });
    }

    /** @test */
    function 정답을_맞춘_퀴즈목록만_조회할_수_있다()
    {
        $this->json("get", "/questions", [
            "correct" => 1
        ])->assertInertia(function ($page){
            $items = $page->toArray()["props"]["items"]["data"];

            $this->assertCount( count($this->correctQuestions), $items);
        });
    }

    /** @test */
    function 정답을_틀린_퀴즈목록만_조회할_수_있다()
    {
        $this->json("get", "/questions", [
            "correct" => 0
        ])->assertInertia(function ($page){
            $items = $page->toArray()["props"]["items"]["data"];

            $this->assertCount( count($this->correctQuestions), $items);
        });
    }

    /** @test */
    function 퀴즈제목을_검색하여_퀴즈목록을_조회할_수_있다()
    {
        $word = "123";

        foreach($this->correctQuestions as $question){
            $question->update(["title" => $word]);
        }
        $this->json("get", "/questions", [
            "word" => $word
        ])->assertInertia(function ($page){
            $items = $page->toArray()["props"]["items"]["data"];

            $this->assertCount( count($this->correctQuestions), $items);
        });
    }
}
