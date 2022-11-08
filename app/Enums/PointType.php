<?php
/**
 * Created by PhpStorm.
 * User: master
 * Date: 2021-01-31
 * Time: 오후 4:04
 */

namespace App\Enums;


final class PointType
{
    const READ_HISTORY_CREATED = "기사완독"; // 기사완독
    const QUIZ_CORRECT = "퀴즈정답"; // 퀴즈정답
    const QUIZ_SHARE = "퀴즈공유"; // 퀴즈공유
    const CURATION_SHARE = "큐레이션공유"; // 큐레이션공유
    const CURATION_SHARE_INCREASE = "조회수10초과"; // 큐레이션공유 조회수 10 늘때마다 쓸건데 포인트타입으로는 안쓸거임

    public static $points = [
        self::READ_HISTORY_CREATED => 3,
        self::QUIZ_CORRECT => 3,
        self::QUIZ_SHARE => 5,
        self::CURATION_SHARE => 10,
        self::CURATION_SHARE_INCREASE => 5,
    ];

    public static function getValues()
    {
        return [self::READ_HISTORY_CREATED, self::QUIZ_CORRECT, self::QUIZ_SHARE, self::CURATION_SHARE];
    }

    public static function options()
    {
        return [
            self::READ_HISTORY_CREATED => "기사완독",
            self::QUIZ_CORRECT => "퀴즈정답",
            self::QUIZ_SHARE => "퀴즈공유",
            self::CURATION_SHARE => "큐레이션공유",
        ];
    }
}
