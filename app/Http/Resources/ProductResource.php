<?php

namespace App\Http\Resources;

use App\Models\Allergy;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $img = $this->img ? $this->img : "";

        if($this->originProduct)
            $img = $this->originProduct->img ? $this->originProduct->img : "";

        return [
            "id" => $this->id,
            "category" => $this->category ? CategoryResource::make($this->category) : "",
            "subCategory" => $this->subCategory ? SubCategoryResource::make($this->subCategory) : "",
            "title" => $this->title,
            "img" => $img,
            "details" => $this->details ? $this->details : "",
            "price" => $this->price,
            "discounted_price" => $this->discounted_price,
            "value_discount" => $this->value_discount,
            "type_discount" => $this->type_discount,
            "department_store" => $this->department_store,
            "direct_store" => $this->direct_store,
            "agency_store" => $this->agency_store,

            // 해당 상품이 가지는 컬러옵션목록
            "colors" => ColorResource::collection($this->colors),

            // 장바구니나 구매할 때 선택한 상품의 색깔
            "color" => $this->color,

            "count_order" => $this->count_order,
            "count_view" => $this->count_view,

            "optionProducts" => OptionProductResource::collection($this->optionProducts), // 옵션상품

            "count" => $this->count, // 구매용 상품으로 만들면서 세팅된 개수

            "created_at" => Carbon::make($this->created_at)->format("Y-m-d H:i"),

            "point_expect" => $this->point_expect, // 예상적립금
            "isLike" => $this->isLike, // 좋아요 여부
            "need_delivery" => $this->need_delivery ? $this->need_delivery : "", // 택배배송 필요여부
            "origin_product_id" => $this->origin_product_id, // 구매용 상품으로 만들어진 경우 본래 상품 id
        ];
    }
}
