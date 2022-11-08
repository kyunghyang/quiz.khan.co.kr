<?php

namespace Tests\Feature\Pages;

use App\Enums\PointType;
use App\Models\Curation;
use App\Models\Newspaper;
use App\Models\PointHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PointHistoriesIndexTest extends TestCase
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
    function 사용자별_획득_포인트랭킹을_조회할_수_있다()
    {
        $rankings = [
            [
                "user" => User::factory()->create(),
                "count" => 10,
            ],
            [
                "user" => User::factory()->create(),
                "count" => 7,
            ],
            [
                "user" => User::factory()->create(),
                "count" => 5,
            ],
        ];

        foreach($rankings as $ranking){
            for($i=0; $i<$ranking["count"]; $i++){
                PointHistory::factory()->create([
                    "user_id" => $ranking["user"]->id,
                    "point" => 3
                ]);
            }
        }

        $this->get("/pointHistories")->assertInertia(function ($page){
            $pointHistories = $page->toArray()["props"]["items"]["data"];

            $prevPointHistory = null;

            foreach($pointHistories as $pointHistory){
                if($prevPointHistory)
                    $this->assertTrue($prevPointHistory["total"] > $pointHistory["total"]);

                $prevPointHistory = $pointHistory;
            }
        });
    }

    /** @test */
    function 특정_기간동안_획득한_사용자별_포인트랭킹을_조회할_수_있다()
    {
        $rankings = [
            [
                "user" => User::factory()->create(),
                "count" => 10,
                "created_at" => Carbon::now()
            ],
            [
                "user" => User::factory()->create(),
                "count" => 1,
                "created_at" => Carbon::now()->subMonth()
            ],
            [
                "user" => User::factory()->create(),
                "count" => 7,
                "created_at" => Carbon::now()->subMonth()
            ],
            [
                "user" => User::factory()->create(),
                "count" => 5,
                "created_at" => Carbon::now()->subMonth()
            ],
        ];

        foreach($rankings as $ranking){
            for($i=0; $i<$ranking["count"]; $i++){
                PointHistory::factory()->create([
                    "user_id" => $ranking["user"]->id,
                    "point" => 3,
                    "created_at" => $ranking["created_at"],
                ]);
            }
        }

        $this->json("get", "/pointHistories", [
            "started_at" => Carbon::now()->subWeek(),
            "finished_at" => Carbon::now()
        ])->assertInertia(function ($page){
            $pointHistories = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(1, $pointHistories);
        });

        $this->json("get", "/pointHistories", [
            "started_at" => Carbon::now()->subMonth(),
            "finished_at" => Carbon::now()->subMonth()
        ])->assertInertia(function ($page){
            $pointHistories = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(3, $pointHistories);
        });
    }

    /** @test */
    function 경험치_타입으로_사용자별_포인트랭킹을_조회할_수_있다()
    {
        $readRankings = [
            [
                "user" => User::factory()->create(),
                "count" => 10,
                "type" => PointType::READ_HISTORY_CREATED
            ],
            [
                "user" => User::factory()->create(),
                "count" => 1,
                "type" => PointType::READ_HISTORY_CREATED
            ],
            [
                "user" => User::factory()->create(),
                "count" => 3,
                "type" => PointType::READ_HISTORY_CREATED
            ],
        ];
        $quizRankings = [
            [
                "user" => User::factory()->create(),
                "count" => 10,
                "type" => PointType::QUIZ_CORRECT
            ],
        ];

        foreach($readRankings as $ranking){
            for($i=0; $i<$ranking["count"]; $i++){
                PointHistory::factory()->create([
                    "user_id" => $ranking["user"]->id,
                    "point" => 3,
                    "type" => $ranking["type"]
                ]);
            }
        }

        foreach($quizRankings as $ranking){
            for($i=0; $i<$ranking["count"]; $i++){
                PointHistory::factory()->create([
                    "user_id" => $ranking["user"]->id,
                    "point" => 3,
                    "type" => $ranking["type"]
                ]);
            }
        }

        $this->json("get", "/pointHistories", [
            "type" =>  PointType::READ_HISTORY_CREATED,
        ])->assertInertia(function ($page) use($readRankings){
            $pointHistories = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(count($readRankings), $pointHistories);
        });

        $this->json("get", "/pointHistories", [
            "type" =>  PointType::QUIZ_CORRECT,
        ])->assertInertia(function ($page) use($quizRankings){
            $pointHistories = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(count($quizRankings), $pointHistories);
        });
    }

    /** @test */
    function 기사완독_타입의_분야로_사용자별_포인트랭킹을_조회할_수_있다()
    {
        $scienceRankings = [
            [
                "user" => User::factory()->create(),
                "count" => 10,
                "category" => "science"
            ],
            [
                "user" => User::factory()->create(),
                "count" => 1,
                "category" => "science"
            ],
            [
                "user" => User::factory()->create(),
                "count" => 3,
                "category" => "science"
            ],
        ];

        $artRankings = [
            [
                "user" => User::factory()->create(),
                "count" => 10,
                "category" => "art"
            ],
            [
                "user" => User::factory()->create(),
                "count" => 1,
                "category" => "art"
            ],
            [
                "user" => User::factory()->create(),
                "count" => 3,
                "category" => "art"
            ],
        ];


        foreach($scienceRankings as $ranking){
            for($i=0; $i<$ranking["count"]; $i++){
                PointHistory::factory()->create([
                    "user_id" => $ranking["user"]->id,
                    "point" => 3,
                    "category" => $ranking["category"]
                ]);
            }
        }

        foreach($artRankings as $ranking){
            for($i=0; $i<$ranking["count"]; $i++){
                PointHistory::factory()->create([
                    "user_id" => $ranking["user"]->id,
                    "point" => 3,
                    "category" => $ranking["category"]
                ]);
            }
        }

        $this->json("get", "/pointHistories", [
            "type" => PointType::READ_HISTORY_CREATED,
            "category" => "science",
        ])->assertInertia(function ($page) use($scienceRankings){
            $pointHistories = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(count($scienceRankings), $pointHistories);
        });

        $this->json("get", "/pointHistories", [
            "type" => PointType::READ_HISTORY_CREATED,
            "category" => "art",
        ])->assertInertia(function ($page) use($artRankings){
            $pointHistories = $page->toArray()["props"]["items"]["data"];

            $this->assertCount(count($artRankings), $pointHistories);
        });
    }



}
