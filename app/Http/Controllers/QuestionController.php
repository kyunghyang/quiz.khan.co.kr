<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(Request $request)
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

        return Inertia::render("Questions/Index", [
            "items" => QuestionResource::customCollection($questions, $user),
            "countTotal" => $countTotal,
            "countCorrect" => $countCorrect,
            "countIncorrect" => $countIncorrect,
            "countTotalPoint" => $countTotalPoint,
            "correct" => isset($request->correct) ? $request->correct : ''
        ]);
    }
}
