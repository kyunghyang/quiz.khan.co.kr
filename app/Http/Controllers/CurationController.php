<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurationResource;
use App\Http\Resources\NewspaperResource;
use App\Http\Resources\TemplateResource;
use App\Models\Curation;
use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CurationController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "word" => "nullable|string|max:500"
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return redirect("/login");

        $curations = $user->curations()->latest();

        $countTotal = $user->curations()->count();

        if($request->word)
            $curations = $curations->where("title", "LIKE", "%".$request->word."%");

        $curations = $curations->paginate(60);

        return Inertia::render("Curations/Index", [
            "items" => CurationResource::collection($curations),
            "countTotal" => $countTotal,
            "word" => $request->word,
            "today" => Carbon::now()->format("Y-m-d")
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "nullable|string|max:500"
        ]);

        if(!$request->title)
            $request["title"] = Carbon::now()->format("Y-m-d");

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return redirect("/login");

        $curation = $user->curations()->create($request->all());

        return redirect()->back()->with("success", "");
    }

    public function destroy(Request $request)
    {
        $request->validate([
            "selected_ids" => "required|array|min:1"
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return redirect("/login");

        $user->curations()->whereIn("id", $request->selected_ids)->delete();

        return redirect()->back()->with("success", "");
    }

    public function show($id, Request $request)
    {
        $request->validate([
            "word" => "nullable|string|max:500",
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        $id = substr($id,8);

        $curation = Curation::find($id);

        if(!$curation)
            return Inertia::render("Errors/404");

        /*
        if(!$user)
            return redirect("/login");*/

        $newspapers = $curation->newspapers()->orderBy("order", "asc");

        if($request->word)
            $newspapers = $newspapers->where("title", "LIKE", "%".$request->word."%");

        $newspapers = $newspapers->paginate(60);

        $templates = Template::orderBy("level_required", "asc")->paginate(60);

        if(!$user || $user->id != $curation->user_id)
            $curation->update(["count_view" => $curation->count_view + 1]);


        return Inertia::render("Curations/Show", [
            "curation" => CurationResource::make($curation),
            "newspapers" => NewspaperResource::collection($newspapers),
            "templates" => TemplateResource::collection($templates),
            "word" => $request->word,
        ]);
    }

    public function update(Curation $curation, Request $request)
    {
        $request->validate([
            "title" => "required|string|max:500"
        ]);

        $curation->update([
            "title" => $request->title
        ]);

        return redirect()->back();
    }

    public function updateAll(Request $request)
    {
        $request->validate([
            "curations" => "required|array|max:500"
        ]);

        $ids = [];

        foreach($request->curations as $curation){
            $ids[] = $curation["id"];

            Curation::find($curation["id"])->update([
                "title" => $curation["title"]
            ]);
        }

        Curation::whereNotIn("id", $ids)->delete();

        return redirect()->back();
    }
    public function updateMemo(Curation $curation, Request $request)
    {
        $request->validate([
            "memo" => "required|string|max:500"
        ]);

        $curation->update([
            "memo" => $request->memo
        ]);

        return redirect()->back();
    }
}
