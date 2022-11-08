<?php

namespace Database\Seeders;

use App\Enums\BrandEventType;
use App\Enums\ShoppingEventType;
use App\Enums\SocialType;
use App\Models\Basic;
use App\Models\BrandBanner;
use App\Models\BrandEvent;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Color;
use App\Models\Curation;
use App\Models\Faq;
use App\Models\Information;
use App\Models\Mood;
use App\Models\NewProduct;
use App\Models\Newspaper;
use App\Models\Notice;
use App\Models\OptionProduct;
use App\Models\Order;
use App\Models\PayMethod;
use App\Models\PointHistory;
use App\Models\Product;
use App\Models\Qna;
use App\Models\ReadHistory;
use App\Models\RecommendProduct;
use App\Models\Review;
use App\Models\ShoppingBanner;
use App\Models\ShoppingEvent;
use App\Models\Social;
use App\Models\SubCategory;
use App\Models\Template;
use App\Models\Usage;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\SubCategoryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\Concerns\Has;
use PhpOption\Option;
use Symfony\Component\Console\Question\Question;

class InitSeeder extends Seeder
{
    protected $user;

    protected $singleProducts;

    protected $dietProducts;

    protected $dietIncludeProducts;

    protected $imgs = [
        "https://swiperjs.com/demos/images/nature-1.jpg",
        "https://swiperjs.com/demos/images/nature-2.jpg",
        "https://swiperjs.com/demos/images/nature-3.jpg",
        "https://swiperjs.com/demos/images/nature-4.jpg",
        "https://swiperjs.com/demos/images/nature-5.jpg",
        "https://swiperjs.com/demos/images/nature-6.jpg",
        "https://swiperjs.com/demos/images/nature-7.jpg",
        "https://swiperjs.com/demos/images/nature-8.jpg",
        "https://swiperjs.com/demos/images/nature-9.jpg",
        "https://swiperjs.com/demos/images/nature-10.jpg",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        Template::truncate();
        Curation::truncate();
        Newspaper::truncate();
        ReadHistory::truncate();
        PointHistory::truncate();
        DB::statement("SET foreign_key_checks=1");

        // $this->createTemplates();

        $this->createUsers();

        $this->createQuestions();

        $this->createCurations();
    }

    public function createTemplates()
    {
        $template = Template::factory()->create([
            "level_required" => 1,
            "color" => "#18407D",
            "background_color" => "#ECF5FE"
        ]);

        $template->addMedia(public_path("img/뱃지1.png"))->preservingOriginal()->toMediaCollection("img_badge", "s3");

        $template = Template::factory()->create([
            "level_required" => 2,
            "color" => "#6E0000",
            "background_color" => "#EBD3D3"
        ]);

        $template->addMedia(public_path("img/뱃지2.png"))->preservingOriginal()->toMediaCollection("img_badge", "s3");

        $template = Template::factory()->create([
            "level_required" => 3,
            "color" => "#4B4E53",
            "background_color" => "#CBCBCB"
        ]);

        $template->addMedia(public_path("img/뱃지1.png"))->preservingOriginal()->toMediaCollection("img_badge", "s3");
        $template->addMedia(public_path("img/배경3.png"))->preservingOriginal()->toMediaCollection("img_background", "s3");
    }
    
    public function createUsers()
    {
        User::factory()->create([
            "unique_id" => "Z66W52d1gdL6I1K+VjSTBA==",
            "name" => "dev-t***",
        ]);

        User::factory()->create([
            "unique_id" => "xUSaWFrfbp0YyCWGgX/F4w==",
            "name" => "khanEm***@khan.co.kr",
        ]);
    }

    public function createQuestions()
    {
        $questions = \App\Models\Question::factory()->count(3)->create([
            "opened_at" => Carbon::now()
        ]);

        foreach($questions as $question){
            \App\Models\Option::factory()->count(4)->create([
                "question_id" => $question->id,
                "correct" => 0
            ]);

            \App\Models\Option::factory()->count(1)->create([
                "question_id" => $question->id,
                "correct" => 1
            ]);
        }

        $questions = \App\Models\Question::factory()->count(3)->create([
            "opened_at" => Carbon::tomorrow()
        ]);

        foreach($questions as $question){
            \App\Models\Option::factory()->count(4)->create([
                "question_id" => $question->id,
                "correct" => 0
            ]);

            \App\Models\Option::factory()->count(1)->create([
                "question_id" => $question->id,
                "correct" => 1
            ]);
        }
    }

    public function createCurations()
    {
        $users = User::get();

        foreach($users as $user){
            $curations = Curation::factory()->count(4)->create([
                "user_id" => $user->id
            ]);

            foreach($curations as $curation){
                $newspapers = Newspaper::factory()->count(4)->create([
                    "curation_id" => $curation->id,
                    "img_url" => $this->imgs[rand(0, count($this->imgs)-1)]
                ]);

                foreach($newspapers as $newspaper){
                    ReadHistory::create([
                        "user_id" => $user->id,
                        "url" => $newspaper->url,
                        "category" => $newspaper->category,
                        "count_text" => strlen($newspaper->description),
                    ]);
                }
            }
        }
    }
}
