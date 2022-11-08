<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            "option_id" => $this->option_id,
            "point" => $this->point,
            "token" => Carbon::make($this->created_at)->format("Ymd").$this->id,
            'user' => UserResource::make($this->user)
        ];
    }
}
