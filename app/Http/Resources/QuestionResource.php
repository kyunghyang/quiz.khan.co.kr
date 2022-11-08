<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    private static $user;

    public function toArray($request)
    {
        $answer = null;

        if(self::$user)
            $answer = $this->answers()->where("user_id", self::$user->id)->first();

        return [
            'id' => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "explain" => $this->explain,
            "answer" => $answer ? AnswerResource::make($answer) : "",
            "options" => OptionResource::collection($this->options),
            "url" => $this->url,
            "title_url" => $this->title_url,
            "point" => $this->point,
            "ratio_correct" => $this->answers()->count() === 0 ? 0 : floor($this->answers()->where("point", ">", 0)->count() / $this->answers()->count() * 100)
        ];
    }

    public static function customCollection($resource, $data)
    {
        self::$user = $data;

        return parent::collection($resource);
    }

    public static function withResource($resource, $user)
    {
        self::$user = $user;

        return parent::make($resource);
    }
}
