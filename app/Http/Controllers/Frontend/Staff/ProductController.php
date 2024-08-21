<?php

namespace App\Http\Controllers\Frontend\Staff;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        return view('frontend.staff.product.index');
    }

    public function getProductList()
    {
        $products = Product::paginate(10);

        $products = ProductResource::collection($products);

        $data = [
            'data' => $products,
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
            'links' => [
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
            ]
        ];

        return success( $data);
    }

    public function getAddToCartOrder()
    {
        $order = Order::with('order_items')->pending()->where('orderable_id', auth()->guard('staff')->user()->id)->first();

        $data = new OrderResource($order);

        return success($data);
    }
}
