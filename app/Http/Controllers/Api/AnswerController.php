<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnswerController extends ApiController
{
    public function store(Request $request)
    {
        $request->validate([
            "question_id" => "required|integer",
            "option_id" => "required|integer",
            "khan_id" => "required|string",
        ]);

        $user = User::where("khan_id", urldecode($request->khan_id))->first();

        if($user)
            return $this->respondForbidden();

        $question = Question::where("opened_at", ">=", Carbon::now()->startOfDay())
            ->where("opened_at", "<=", Carbon::now()->endOfDay())
            ->where("id", $request->question_id)
            ->first();

        if(!$question)
            return $this->respondForbidden("오늘 공개된 퀴즈가 없습니다.");

        if($question->answers()->where("user_id", $user->id)->first())
            return $this->respondForbidden("이미 답변한 퀴즈에 재답변할 수 없습니다.");

        $option = $question->options()->find($request->option_id);

        if(!$option)
            return $this->respondForbidden("존재하지 않는 옵션입니다.");

        $answer = $user->answers()->create([
            "option_id" => $option->id,
            "question_id" => $question->id,
        ]);

        $question = $answer->question;

        return $this->respondSuccessfully(QuestionResource::make($question));
    }
}
