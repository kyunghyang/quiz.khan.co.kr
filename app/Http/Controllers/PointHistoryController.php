<?php

namespace App\Http\Controllers;

use App\Enums\PointType;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PointHistoryResource;
use App\Models\Category;
use App\Models\PointHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PointHistoryController extends Controller
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
            ->groupBy("user_id")
            ->orderBy("total", "desc");

        if($request->started_at && $request->finished_at)
            $pointHistories = $pointHistories
                ->where("created_at", ">=", Carbon::make($request->started_at)->startOfDay())
                ->where("created_at", "<=", Carbon::make($request->finished_at)->endOfDay());

        if($request->category)
            $pointHistories = $pointHistories->whereHas("readHistory", function($query) use($request){
                $query->where("category", $request->category);
            });

        if($request->type)
            $pointHistories = $pointHistories->where("type", $request->type);
        else
            $pointHistories = $pointHistories->where(function($query){
                $query->where("type", PointType::READ_HISTORY_CREATED)
                    ->orWhere("type", PointType::QUIZ_CORRECT)
                    ->orWhere("type", PointType::CURATION_SHARE);
            });

        $pointHistories = $pointHistories->paginate(15);

        return Inertia::render("PointHistories/Index", [
            "categories" => CategoryResource::collection(Category::where("open", true)->oldest()->paginate(300)),
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
}
