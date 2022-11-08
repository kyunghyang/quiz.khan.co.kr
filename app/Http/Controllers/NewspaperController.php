<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurationResource;
use App\Http\Resources\UserResource;
use App\Models\Curation;
use App\Models\Newspaper;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewspaperController extends Controller
{
    public function create(Request $request)
    {
        $user = User::where("unique_id", $request->khan_id)->first();

        /*if(!$user)
            return redirect("/login");*/

        $already = 0;

        if($user)
            $already = $user->newspapers()->where("url", $request->url)->first() ? 1 : 0;

        $curations = $user ? $user->curations()->latest()->paginate(60) : "";

        return Inertia::render("Newspapers/Create", [
            "curations" => $curations ? CurationResource::collection($curations) : "",
            "url" => $request->url,
            "already" => $already,
            "user" => $user ? UserResource::make($user) : "",
        ]);
    }

    /*public function store(Request $request)
    {
        $request->validate([
            "curation_ids" => "nullable|array",
            "url" => "required|string",
            "img_url" => "nullable|string|max:500",
            "title" => "nullable|string|max:500",
            "description" => "nullable|string|max:50000",
        ]);

        if(!$request->curation_ids)
            return redirect()->back()->with("error", "저장할 큐레이션을 선택하세요.");



        foreach($request->curations_ids as $curations_id){
            $curation = Curation::find($request->curation_id);

            if(!$curation)
                return redirect()->back()->with("error", "존재하지 않는 큐레이션입니다.");

            if($curation->user_id != auth()->id())
                return redirect()->back()->with("error", "자신의 큐레이션만 사용할 수 있습니다.");

            $alreadyStored = $curation->newspapers()->where("url", $request->url)->first();

            if($alreadyStored)
                return redirect()->back()->with("error", "이미 큐레이션에 저장된 기사입니다.");

            if(!$alreadyStored && $curation->newspapers()->count() < 5)
                $curation->newspapers()->create($request->all());
        }

        return redirect()->back()->with("success", "큐레이션에 저장하였습니다.");
    }*/

    public function destroy(Request $request)
    {
        $request->validate(["selected_ids"=>"required|array|min:1"]);

        /*if($newspaper->curation->user_id != auth()->id())
            return redirect()->back()->with("error", "자신의 큐레이션에서만 뉴스를 삭제할 수 있습니다.");

        $newspaper->delete();
    */

        Newspaper::whereIn("id", $request->selected_ids)->delete();

        return redirect()->back()->with("success", "");
    }

    public function next(Newspaper $newspaper)
    {
        $newspapers = $newspaper->curation->newspapers()->orderBy("order", "asc")->cursor();

        $target = $newspaper->curation->newspapers()->orderBy("order", "asc")->where("order", ">" ,$newspaper->order)->first();

        if($target){
            foreach($newspapers as $newspaperData){
                if($newspaperData->order == $target->order){
                    $newspaperData->update(["order" => $newspaper->order]);
                    $newspaper->update(["order" => $target->order]);

                    break;
                }
            }
        }


        return redirect()->back()->with("success", "");
    }

    public function prev(Newspaper $newspaper)
    {
        $newspapers = $newspaper->curation->newspapers()->orderBy("order", "desc")->cursor();

        $target = $newspaper->curation->newspapers()->orderBy("order", "desc")->where("order", "<" ,$newspaper->order)->first();

        if($target){
            foreach($newspapers as $newspaperData){
                if($newspaperData->order == $target->order){
                    $tmp = $target->order;

                    $newspaperData->update(["order" => $newspaper->order]);
                    $newspaper->update(["order" => $tmp]);

                    break;
                }
            }
        }

        return redirect()->back()->with("success", "");
    }

    public function updateAll(Request $request)
    {
        $ids = [];

        $curation = Curation::find($request->curation_id);

        $curation->update(["memo" => $request->memo]);

        foreach($request->newspapers as $newspaper){
            $ids[] = $newspaper["id"];

            if(!$newspaperData)
                $newspaperData = Newspaper::find($newspaper["id"]);

            Newspaper::find($newspaper["id"])->update(["order" => $newspaper["order"]]);
        }



        Newspaper::whereNotIn("id", $ids)->delete();

        return redirect()->back();
    }
}
