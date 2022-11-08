<?php

namespace App\Http\Resources;

use App\Enums\PointType;
use App\Models\Cart;
use App\Models\ReadHistory;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $badge = Template::orderBy("level_required", "desc")->where("level_required", "<=", $this->level)->first();

        return [
            "id" => $this->id,
            "unique_id" => $this->unique_id,
            "name" => $this->name,
            "point" => $this->point,
            "level" => $this->level,
            "template" => $this->template ? [
                "img_badge" => [
                    "url" => $badge->img_badge ? "https://201413386.s3.ap-northeast-2.amazonaws.com/".$badge->img_badge : ""
                ],
                "img_background" => [
                    "url" => $this->template->img_background ? "https://201413386.s3.ap-northeast-2.amazonaws.com/".$this->template->img_background : ""
                ],
            ] : "",
            // "count_read_history" => $this->readHistories()->count(),
            "newsTotalBook" => $this->readHistories()->count(),
            "count_curation" => $this->curations()->count(),
            "count_quiz" => $this->answers()->count(),
            "count_quiz_point" => $this->pointHistories()->where("type", PointType::QUIZ_CORRECT)->sum("point"),
            "ratio_correct" => $this->answers()->count() === 0 ? 0 : floor($this->answers()->where("point", ">", 0)->count() / $this->answers()->count() * 100),

            "created_at" => Carbon::make($this->created_at)->format("Y-m-d H:i"),
            "updated_at" => Carbon::make($this->updated_at)->format("Y-m-d H:i"),

        ];
    }
}
