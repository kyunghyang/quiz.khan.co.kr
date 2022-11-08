<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "level_required" => $this->level_required,
            "color" => $this->color,
            "background_color" => $this->background_color,
            "img_badge" => [
                "url" => $this->img_badge ? "https://201413386.s3.ap-northeast-2.amazonaws.com/".$this->img_badge : ""
            ],
            "img_background" => [
                "url" => $this->img_background ? "https://201413386.s3.ap-northeast-2.amazonaws.com/".$this->img_background : ""
            ],
        ];
    }
}
