<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Enums\PointType;
use App\Http\Resources\CategoryResource;
use App\Models\ReadHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReadHistoryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "category" => "nullable|string|max:500"
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return redirect("/login");

        $request["category"] = $request->category ?? \App\Models\Category::where("open", true)->oldest()->first()->code;

        $countTotal = $user->readHistories()->count();

        $countTotalText = $user->readHistories()->sum("count_text");

        $countTotalBook = floor($user->readHistories()->sum("count_text") / ReadHistory::getBookUnit());

        $countCategoryTotal = $user->readHistories()->where("category", $request->category)->count();

        $countCategoryTotalText = $user->readHistories()->where("category", $request->category)->sum("count_text");

        $countCategoryTotalBook = floor($user->readHistories()->where("category", $request->category)->sum("count_text") / ReadHistory::getBookUnit());

        $categories = \App\Models\Category::where("open", true)->oldest()->paginate(60);


        return Inertia::render("ReadHistories/Index", [
            "countTotal" => $countTotal,
            "countTotalText" => $countTotalText,
            "countTotalBook" => $countTotalBook,
            "countCategoryTotal" => $countCategoryTotal,
            "countCategoryTotalText" => $countCategoryTotalText,
            "countCategoryTotalBook" => $countCategoryTotalBook,
            "categories" => CategoryResource::collection($categories),
            "category" => $request->category,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render("ReadHistories/Create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "url" => "required|string|max:500",
            "category" => "required|string|max:500",
            "count_text" => "required|integer|min:0",
            "title" => "nullable|string|max:500000",
            "description" => "nullable|string|max:500000",
        ]);

        $point = PointType::$points[PointType::READ_HISTORY_CREATED];

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return redirect("/login");

        $alreadyRead = $user->readHistories()->where("url", $request->url)->exists();

        if($alreadyRead)
            return redirect()->back();

        $readHistory = $user->readHistories()->create($request->all());

        return redirect()->back()->with("success", "기사 완독! 경험치 획득 +".$point);
    }
}
