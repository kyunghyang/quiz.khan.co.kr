<?php

namespace Database\Seeders;

use App\Enums\OrderState;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Database\Seeder;

class RecordRefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::where("state", OrderState::REFUND)->get();

        foreach($orders as $order){
            Refund::updateOrCreate([
                "order_id" => $order->id,
            ], [
                "user_id" => $order->user_id,
                "reason_request" => "주문취소",
                "refunded" => 1,
                "price" => $order->price_real,
                "type" => "주문취소"
            ]);
        }
    }
}
