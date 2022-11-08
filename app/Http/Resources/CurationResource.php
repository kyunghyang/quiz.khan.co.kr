<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CurationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $newspaper = $this->newspapers()->first();

        $imgUrl = "";

        if($newspaper)
            $imgUrl = $newspaper->img_url;

        return [
            "id" => $this->id,
            "user" => UserResource::make($this->user),
            "user_id" => $this->user_id,
            "title" => $this->title,
            "img_url" => $imgUrl == "" ? "/img/replace.png" : $imgUrl,
            "count_view" => $this->count_view,
            "memo" => $this->memo,
            "token" => Carbon::make($this->created_at)->format("Ymd").$this->id
        ];
    }
}
