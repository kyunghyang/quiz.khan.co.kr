<?php

namespace Tests\Feature;

use App\Models\PointHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PointHistoriesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $form;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);
    }

    /** @test */
    function 경험치기록이_생성되면_레벨범위를_조회하여_사용자의_레벨을_갱신한다()
    {
        $this->assertEquals(1, $this->user->level);

        $leave = 10;

        $point = PointHistory::getLevelUpPoint() - $leave;

        PointHistory::factory()->create([
            "point" => $point
        ]);

        $user = User::find($this->user->id);

        $this->assertEquals(1, $user->level);

        $this->assertEquals($point, $user->point);

        PointHistory::factory()->create([
            "point" => $leave + 3
        ]);

        $user = User::find($this->user->id);

        $this->assertEquals(2, $user->level);

        $this->assertEquals(3, $user->point);
    }
}
