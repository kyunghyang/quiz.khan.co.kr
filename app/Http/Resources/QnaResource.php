<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QnaResource extends JsonResource
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
            "site_type" => $this->site_type,
            "type" => $this->type,
            "service_type" => $this->service_type,
            "order_name" => $this->order_name,
            "description" => $this->description,
            "name" => $this->name,
            "email" => $this->email,
            "contact" => $this->contact,
            "address" => $this->address,
            "address_detail" => $this->address_detail,
            "address_zipcode" => $this->address_zipcode,
            "contact_time" => $this->contact_time,
            "files" => $this->files ?? "",
            "answer" => $this->answer,
            "answer_name" => $this->answer_name,
            "answer_contact" => $this->answer_contact,
            "created_at" => Carbon::make($this->created_at)->format("Y.m.d")
        ];
    }
}
