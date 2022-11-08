<?php
/**
 * Created by PhpStorm.
 * User: master
 * Date: 2021-01-31
 * Time: 오후 4:04
 */

namespace App\Enums;


final class Category
{
    const POLITICS = "정치"; // 정치
    const ECONOMY = "경제"; // 정치
    const SOCIAL = "사회"; // 정치
    const INTERNATIONAL = "국제"; // 정치
    const CULTURE = "문화"; // 정치
    const SPORTS = "스포츠"; // 정치
    const ENTERTAINMENTS = "오피니언"; // 오피니언
    const SCIENCE = "과학"; // 정치

    public static function getValues()
    {
        return [
            self::POLITICS,
            self::ECONOMY,
            self::SOCIAL,
            self::INTERNATIONAL,
            self::CULTURE,
            self::SPORTS,
            self::ENTERTAINMENTS,
            self::SCIENCE,
        ];
    }

    public static function convert($code)
    {
        if($code == "123")
            return self::POLITICS;
    }

    public static function options()
    {
        return [
            self::POLITICS => "정치",
            self::ECONOMY => "경제",
            self::SOCIAL => "사회",
            self::INTERNATIONAL => "국제",
            self::CULTURE => "문화",
            self::SPORTS => "스포츠",
            self::ENTERTAINMENTS => "오피니언",
            self::SCIENCE => "과학",
        ];
    }
}
