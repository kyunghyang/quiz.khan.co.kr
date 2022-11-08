<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curation;
use App\Models\User;
use Illuminate\Http\Request;

class NewspaperController extends ApiController
{
    public function store(Request $request)
    {
        $request->validate([
            "khan_id" => "required|string",
            "curation_ids" => "required|array",
            "url" => "required|string",
            "img_url" => "nullable|string|max:500",
            "title" => "nullable|string|max:500",
            "description" => "nullable|string|max:50000",
        ]);


        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return $this->respondForbidden("존재하지 않는 사용자입니다.");

        foreach($request->curation_ids as $curation_id){
            $curation = Curation::find($curation_id);

            $alreadyStored = $curation->newspapers()->where("url", $request->url)->first();

            if($curation && !$alreadyStored && $curation->newspapers()->count() < 5) {
                $curation->newspapers()->create($request->all());
            }
        }

        /*$alreadyStored = $curation->newspapers()->where("url", $request->url)->first();

        if(!$alreadyStored)
            $curation->newspapers()->create($request->all());*/

        return $this->respondSuccessfully(null, "큐레이션에 저장되었습니다.");
    }

}
