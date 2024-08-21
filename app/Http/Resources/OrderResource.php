<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order_items = $this->order_items;

        $total_product = $order_items->count();
        $total_price = $order_items->sum('price');
        $total_quantity = $order_items->sum('quantity');
        $tax = 0;
        $total_amount = $total_price + $tax;

        return [
            'id' => $this->id,
            'orderable' => $this->orderable,
            'order_items' => OrderItemResource::collection($order_items),
            'total_product' => number_format($total_product),
            'total_price' => number_format($total_price) . ' MMK',
            'total_quantity' => number_format($total_quantity),
            'tax' => number_format($tax) . ' MMK',
            'total_amount' => number_format($total_amount) . ' MMK',
        ];
    }
}
