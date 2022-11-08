<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TemplateSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Template::truncate();
        DB::statement("SET foreign_key_checks=1");

        $templates = [
            [
                "level_required" => 1,
                "color" => "#18407D",
                "background_color" => "#ECF5FE",
                "img_badge" => null,
                "img_background" => null
            ],
            [
                "level_required" => 2,
                "color" => "#000",
                "background_color" => "#fff",
                "img_badge" => "뱃지2.png",
                "img_background" => "2레벨.png"
            ],
            [
                "level_required" => 3,
                "color" => "#000",
                "background_color" => "#fff",
                "img_badge" => "뱃지3.png",
                "img_background" => "3레벨.png"
            ],
            [
                "level_required" => 4,
                "color" => "#000",
                "background_color" => "#fff",
                "img_badge" => "뱃지4.png",
                "img_background" => "4레벨.png"
            ],
            [
                "level_required" => 5,
                "color" => "#000",
                "background_color" => "#fff",
                "img_badge" => "뱃지5.png",
                "img_background" => "5레벨.png"
            ],
            [
                "level_required" => 6,
                "color" => "#000",
                "background_color" => "#cad6e6",
                "img_badge" => "뱃지6.png",
                "img_background" => "6레벨.png"
            ],
            [
                "level_required" => 7,
                "color" => "#000",
                "background_color" => "#f6ebe9",
                "img_badge" => "뱃지7.png",
                "img_background" => "7레벨.png"
            ],
            [
                "level_required" => 8,
                "color" => "#fff",
                "background_color" => "#000",
                "img_badge" => "뱃지8.png",
                "img_background" => "8레벨.png"
            ],
            [
                "level_required" => 9,
                "color" => "#18407d",
                "background_color" => "#fff",
                "img_badge" => "뱃지9.png",
                "img_background" => "9레벨.png"
            ],

            [
                "level_required" => 10,
                "color" => "#000",
                "background_color" => "#e6e6e6",
                "img_badge" => "뱃지10.png",
                "img_background" => "10레벨.png"
            ],
        ];

        foreach($templates as $template){
            // Storage::disk("s3")->put($template["img_badge"], Storage::disk("public")->get($template["img_badge"]));
            // Storage::disk("s3")->put($template["img_background"], Storage::disk("public")->get($template["img_background"]));

            $createdTemplate = Template::create($template);
        }
    }
}
