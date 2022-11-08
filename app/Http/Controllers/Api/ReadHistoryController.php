<?php

namespace App\Http\Controllers\Api;

use App\Enums\PointType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReadHistoryController extends ApiController
{
    public function store(Request $request)
    {
        $request->validate([
            "khan_id" => "required|string",
            "url" => "required|string|max:500",
            "category" => "required|string|max:500",
            "count_text" => "required|integer|min:0",
            "title" => "nullable|string|max:500000",
            "description" => "nullable|string|max:500000",
        ]);

        $user = User::where("unique_id", urldecode($request->khan_id))->first();

        if(!$user)
            return $this->respondNotFound();

        $alreadyRead = $user->readHistories()->where("url", $request->url)->exists();

        if(!$alreadyRead) {
            $category = $request->category;
            $subCategory = null;

            if(strlen($request->category) > 2){
                $subCategory = $request->category;

                $category = substr($request->category,0, 2);
            }

            $user->readHistories()->create(array_merge($request->all(), [
                "category" => $category,
                "sub_category" => $subCategory
            ]));

            return $this->respondSuccessfully(null,"기사 완독! 경험치 획득 +".PointType::$points[PointType::READ_HISTORY_CREATED]);
        }
    }
}
