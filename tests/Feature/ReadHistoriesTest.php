<?php

namespace Tests\Feature;

use App\Enums\PointType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadHistoriesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $form;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);

        $this->form = [
            "user_id" => true,
            "url" => "https://naver.com",
            "category" => "123",
            "count_text" => 123
        ];
    }

    /** @test */
    function 사용자는_읽음기록을_생성할_수_있다()
    {
        $this->post("/readHistories", $this->form);

        $this->assertCount(1, $this->user->readHistories);
    }

    /** @test */
    function 사용자는_같은기사_url에_중복_읽음기록을_생성할_수_없다()
    {
        $this->post("/readHistories", $this->form);

        $this->assertCount(1, $this->user->readHistories);

        $this->post("/readHistories", $this->form);

        $this->assertCount(1, $this->user->readHistories);
    }

    /** @test */
    function 읽음기록이_생성되면_사용자에게_경험치가_부여된다()
    {
        $this->post("/readHistories", $this->form);

        $user = User::find($this->user->id);

        $this->assertEquals(PointType::$points[PointType::READ_HISTORY_CREATED], $user->point);
    }


}
