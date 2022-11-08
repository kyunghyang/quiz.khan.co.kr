<?php

namespace App\Observers;

use App\Enums\KakaoTemplate;
use App\Enums\OrderState;
use App\Enums\PointType;
use App\Models\Kakao;
use App\Models\Order;
use Carbon\Carbon;

class OrderObserver
{
    public function updated(Order $order)
    {

    }
}
