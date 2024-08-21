<?php

namespace App\Http\Controllers\Frontend\Staff;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
