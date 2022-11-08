<?php

namespace Tests\Feature;

use App\Models\Curation;
use App\Models\Newspaper;
use App\Models\PointHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewspapersTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $other;

    protected $curation;

    protected $form;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->other = User::factory()->create();

        $this->actingAs($this->user);

        $this->curation = Curation::factory()->create([
            "user_id" => $this->user->id,
        ]);

        $this->form = [
            "curation_id" => $this->curation->id,
            "url" => "123123",
        ];
    }

    /** @test */
    function 자신의_기사를_큐레이션에_저장할_수_있다()
    {
        $this->post("/newspapers", $this->form);

        $this->assertCount(1, Newspaper::all());
    }

    /** @test */
    function 자신의_큐레이션에만_기사를_저장할_수_있다()
    {
        /** @test */
        $curation = Curation::factory()->create([
            "user_id" => $this->other->id
        ]);

        $this->form["curation_id"] = $curation->id;

        $this->post("/newspapers", $this->form);

        $this->assertCount(0, Newspaper::all());
    }

   /* function 자신의_기사를_큐레이션에서_삭제할_수_있다()
    {
        $newspaper = Newspaper::factory()->create([
            "curation_id" => $this->curation->id
        ]);

        $this->delete("/newspapers/". $newspaper->id);

        $this->assertCount(0, Newspaper::all());
    }

    function 자신의_큐레이션에_있는_기사만_삭제할_수_있다()
    {
        $otherCuration = Curation::factory()->create([
            "user_id" => $this->other->id
        ]);

        $newspaper = Newspaper::factory()->create([
            "curation_id" => $otherCuration->id
        ]);

        $this->delete("/newspapers/". $newspaper->id);

        $this->assertCount(1, Newspaper::all());
    }*/

    /** @test */
    function 같은_큐레이션에_중복기사를_저장할_수_없다()
    {
        $this->post("/newspapers", $this->form);

        $this->assertCount(1, Newspaper::all());

        $this->post("/newspapers", $this->form);

        $this->assertCount(1, Newspaper::all());
    }
}
