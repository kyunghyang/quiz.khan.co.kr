<?php

namespace App\Http\Controllers;

use App\Enums\OrderProductState;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\EventBannerResource;
use App\Models\Category;
use App\Models\EventBanner;
use App\Models\Template;
use App\Models\User;
use App\Models\VerifyNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class UserController
{

    public function updateTemplate(Request $request)
    {
        $request->validate([
            "template_id" => "required|integer",
            "khan_id" => "required"
        ]);

        $user = User::where("unique_id", $request->khan_id)->first();

        if($user){
            $template = Template::find($request->template_id);

            if(!$template)
                return redirect()->back()->with("error", "존재하지 않는 템플릿입니다.");

            if($template->level_required > $user->level)
                return redirect()->back()->with("error", "요구레벨을 충족하지 않습니다.");

            $user->update([
                "template_id" => $request->template_id
            ]);
        }

        return redirect()->back()->with("success", "성공적으로 처리되었습니다.");
    }

    public function loginForm()
    {
        return Inertia::render("Users/Login",[]);
    }

}
