<?php

namespace App\Http\Controllers;

use App\Enums\PointType;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\CurationResource;
use App\Http\Resources\NewspaperResource;
use App\Http\Resources\PointHistoryResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\TemplateResource;
use App\Http\Resources\UserResource;
use App\Models\Answer;
use App\Models\Curation;
use App\Models\PointHistory;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "type" => "nullable|string|max:500",
            "started_at" => "nullable|string|max:500",
            "finished_at" => "nullable|string|max:500",
            "category" => "nullable|string|max:500"
        ]);

        $request["year"] = $request->year ?? Carbon::now()->year;
        $request["month"] = $request->month ?? Carbon::now()->month;
        $request["duration"] = $request->duration ?? "일간";

        if($request->duration == "일간"){
            $request["started_at"] = Carbon::now()->setYear($request->year)->setMonth($request->month);
            $request["finished_at"] = Carbon::now()->setYear($request->year)->setMonth($request->month);
        }

        if($request->duration == "주간"){
            $request["started_at"] = Carbon::now()->setYear($request->year)->setMonth($request->month)->startOfWeek();
            $request["finished_at"] = Carbon::now()->setYear($request->year)->setMonth($request->month)->endOfWeek();
        }

        if($request->duration == "월간"){
            $request["started_at"] = Carbon::now()->setYear($request->year)->setMonth($request->month)->startOfMonth();
            $request["finished_at"] = Carbon::now()->setYear($request->year)->setMonth($request->month)->endOfMonth();
        }

        $pointHistories = PointHistory::select(DB::raw("*, SUM(point) as total"))
            ->where("type", PointType::QUIZ_CORRECT)
            ->groupBy("user_id")
            ->orderBy("total", "desc");

        if($request->started_at && $request->finished_at)
            $pointHistories = $pointHistories
                ->where("created_at", ">=", Carbon::make($request->started_at)->startOfDay())
                ->where("created_at", "<=", Carbon::make($request->finished_at)->endOfDay());

        if($request->category)
            $pointHistories = $pointHistories->where("category", $request->category);

        if($request->type)
            $pointHistories = $pointHistories->where("type", $request->type);
        else
            $pointHistories = $pointHistories->where(function($query){
                $query->where("type", PointType::READ_HISTORY_CREATED)
                    ->orWhere("type", PointType::QUIZ_CORRECT)
                    ->orWhere("type", PointType::CURATION_SHARE);
            });

        $pointHistories = $pointHistories->paginate(15);

        return Inertia::render("Answers/Index", [
            "items" => PointHistoryResource::collection($pointHistories),
            "type" => $request->type ?? "",
            "started_at" => Carbon::make($request->started_at)->format("Y-m-d"),
            "finished_at" => Carbon::make($request->finished_at)->format("Y-m-d"),
            "category" => $request->category ?? "",

            "year" => $request->year,
            "month" => $request->month,
            "duration" => $request->duration,
        ]);
    }

    public function show($id, Request $request)
    {
        // $user = User::where("unique_id", $request->khan_id)->first();

        $id = substr($id,8);

        $answer = Answer::find($id);

        if(!$answer)
            return redirect()->back()->with("error", "존재하지 않는 큐레이션입니다.");

        $answer->update(["count_view" => $answer->count_view + 1]);

        $question = $answer->question;

        return Inertia::render("Answers/Show", [
            "answer" => AnswerResource::make($answer),
            "question" => QuestionResource::make($question)
        ]);
    }

    public function create(Request $request)
    {
        $user = User::where("unique_id", $request->khan_id)->first();

        /*if(!$user)
            return redirect("/login");*/

        $questions = Question::where("opened_at", ">=", Carbon::now()->startOfDay())
            ->where("opened_at", "<=", Carbon::now()->endOfDay())
            ->where("public", true)
            ->paginate(60);

        $request["activeIndex"] = $request->activeIndex ?? 0;

        return Inertia::render("Answers/Create", [
            "questions" => QuestionResource::customCollection($questions, $user),
            "activeIndex" => $request->activeIndex,
            "user" => $user ? UserResource::make($user) : ""
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            "question_id" => "required|integer",
            "option_id" => "required|integer",
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return redirect("/login");

        $question = Question::where("opened_at", ">=", Carbon::now()->startOfDay())
            ->where("opened_at", "<=", Carbon::now()->endOfDay())
            ->where("id", $request->question_id)
            ->first();

        if(!$question)
            return redirect()->back()->with("error", "오늘 공개된 퀴즈가 없습니다.");

        if($question->answers()->where("user_id", $user->id)->first())
            return redirect()->back()->with("error", "이미 답변한 퀴즈에 재답변할 수 없습니다.");

        $option = $question->options()->find($request->option_id);

        if(!$option)
            return redirect()->back()->with("error", "존재하지 않는 옵션입니다.");

        $user->answers()->create([
            "option_id" => $option->id,
            "question_id" => $question->id,
        ]);

        return redirect()->back()->with("success", "성공적으로 처리되었습니다.");
    }

    public function questions(Request $request)
    {
        $request->validate([
            "correct" => "nullable|boolean",
            "word" => 'nullable|string|max:500'
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return redirect("/login");

        $questions = Question::whereHas("answers", function($query) use($user){
            return $query->where("user_id", $user->id);
        });

        if(isset($request->correct))
            $questions = $questions->whereHas("answers", function($query) use($request){
                return $request->correct ? $query->where("point", ">", 0) : $query->where("point", "=", 0);
            });

        if(isset($request->word))
            $questions = $questions->where("title", "LIKE", "%".$request->word."%");

        $questions = $questions->latest()->paginate(15);

        $countTotal = Question::whereHas("answers", function($query) use($user){
            return $query->where("user_id", $user->id);
        })->count();

        $countCorrect = Question::whereHas("answers", function($query) use($user){
            return $query->where("user_id", $user->id)->where("point", ">", 0);
        })->count();

        $countIncorrect = Question::whereHas("answers", function($query) use($user){
            return $query->where("user_id", $user->id)->where("point", "=", 0);
        })->count();

        $countTotalPoint = $user->answers()->sum("point");

        return Inertia::render("Answers/Questions", [
            "items" => QuestionResource::customCollection($questions, $user),
            "countTotal" => $countTotal,
            "countCorrect" => $countCorrect,
            "countIncorrect" => $countIncorrect,
            "countTotalPoint" => $countTotalPoint,
            "word" => $request->word,
            "correct" => isset($request->correct) ? $request->correct : ''
        ]);
    }
}
