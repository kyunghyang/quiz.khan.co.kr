<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function show(Request $request)
    {
        $request->validate([
            "khan_id" => "required"
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        if(!$user)
            return $this->respondNotFound();

        return $this->respondSuccessfully(UserResource::make($user));
    }
}
