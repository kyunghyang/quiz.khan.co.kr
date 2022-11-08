<?php

namespace Tests\Feature;

use App\Enums\PointType;
use App\Models\Answer;
use App\Models\Curation;
use App\Models\Newspaper;
use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\OptionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnswersTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $other;

    protected $form;

    protected $correctOption;

    protected $incorrectOption;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->other = User::factory()->create();

        $this->actingAs($this->user);

        $question = Question::factory()->create([
            "opened_at" => Carbon::now()
        ]);

        $this->incorrectOption = Option::factory()->create([
            "question_id" => $question->id,
            "correct" => 0,
            "title" => "123"
        ]);

        $this->correctOption = Option::factory()->create([
            "question_id" => $question->id,
            "correct" => 1,
            "title" => "123"
        ]);

        $this->form = [
            "question_id" => $question->id,
            "option_id" => $this->correctOption->id
        ];
    }

    /** @test */
    function 사용자는_정답을_제출할_수_있다()
    {
        $this->post("/answers", $this->form);

        $this->assertCount(1, Answer::all());
    }

    /** @test */
    function 사용자는_오픈된_퀴즈에만_정답을_제출할_수_있다()
    {
        $notOpenQuestion = Question::factory()->create([
            "opened_at" => Carbon::yesterday()
        ]);

        $this->form["question_id"] = $notOpenQuestion->id;

        $this->post("/answers", $this->form);

        $this->assertCount(0, Answer::all());
    }

    /** @test */
    function 사용자는_같은_퀴즈에_대해_2개_이상의_정답을_제출할_수_있다()
    {
        $this->post("/answers", $this->form);

        $this->assertCount(1, Answer::all());

        $this->post("/answers", $this->form);

        $this->assertCount(1, Answer::all());
    }

    /** @test */
    /*function 사용자는_정답을_맞췄을_경우_경험치를_받게_된다()
    {
        $this->form["option_id"] = $this->incorrectOption->id;

        $this->post("/answers", $this->form);

        $user = User::find($this->user->id);

        $this->assertEquals(0, $user->point);

        $this->form["option_id"] = $this->correctOption->id;

        $this->post("/answers", $this->form);

        $user = User::find($this->user->id);

        $this->assertEquals(PointType::$points[PointType::QUIZ_CORRECT], $user->point);
    }*/
}
