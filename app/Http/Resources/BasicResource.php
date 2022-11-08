<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BasicResource extends JsonResource
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
            "point_level_up" => $this->point_level_up,
            "point_read_history" => $this->point_read_history,
            "point_question" => $this->point_question,
            "point_curation" => $this->point_curation,
        ];
    }
}
