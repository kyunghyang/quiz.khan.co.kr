<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NewspaperResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "order" => $this->order,
            "img_url" => $this->img_url ? $this->img_url : "/img/replace.png",
            "url" => $this->url ?? "",
            "created_at" => Carbon::make($this->created_at)->format("Y-m-d")
        ];
    }
}
