<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                "title" => "정치",
                "code" => "91",
                "open" => true,
            ],
            [
                "title" => "경제",
                "code" => "92",
                "open" => true,
            ],
            [
                "title" => "사회",
                "code" => "94",
                "open" => true,
            ],
            [
                "title" => "지역",
                "code" => "95",
                "open" => false,
            ],
            [
                "title" => "국제",
                "code" => "97",
                "open" => true,
            ],
            [
                "title" => "문화",
                "code" => "96",
                "open" => true,
            ],
            [
                "title" => "스포츠",
                "code" => "98",
                "open" => true,
            ],
            [
                "title" => "오피니언",
                "code" => "99",
                "open" => true,
            ],

            [
                "title" => "인물",
                "code" => "10",
                "open" => false,
            ],

            [
                "title" => "기획",
                "code" => "21",
                "open" => false,
            ],

            [
                "title" => "과학",
                "code" => "61",
                "open" => true,
            ],

            [
                "title" => "IT",
                "code" => "93",
                "open" => false,
            ],
            [
                "title" => "만평",
                "code" => "36",
                "open" => false,
            ],
            [
                "title" => "라이프",
                "code" => "90",
                "open" => false,
            ],
            [
                "title" => "영문",
                "code" => "79",
                "open" => false,
            ],
            [
                "title" => "영문",
                "code" => "71",
                "open" => false,
            ],
            [
                "title" => "라이프",
                "code" => "90",
                "open" => false,
            ],
            [
                "title" => "지식발전소",
                "code" => "83",
                "open" => false,
            ],

            [
                "title" => "지역",
                "code" => "62",
                "open" => false,
            ],
            [
                "title" => "미분류",
                "code" => "00",
                "open" => false,
            ],

        ];

        foreach($categories as $category){
            Category::create($category);
        }
    }
}
