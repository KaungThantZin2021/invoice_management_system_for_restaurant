<?php

namespace App\Http\Controllers\Backend\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::query();

            return DataTables::of($orders)
                ->addColumn('orderable', function ($order) {
                    return optional($order->orderable)->name . ' (' . class_basename($order->orderable) . ')';
                })
                ->addColumn('action', function ($order) {
                    $edit_btn = '<a href="'. route('admin.order.edit', $order->id) .'" class="btn btn-sm btn-warning m-2"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $info_btn = '<a href="'. route('admin.order.show', $order->id) .'" class="btn btn-sm btn-primary m-2"><i class="fa-solid fa-circle-info"></i></a>';
                    $invoice_generate_btn = '<a href="'. route('admin.invoice.show', $order->id) .'" class="btn btn-sm btn-info m-2"><i class="fa-solid fa-file-invoice"></i></a>';
                    $delete_btn = '<a href="#" class="btn btn-sm btn-danger m-2 delete-btn" data-delete-url="' . route('admin.order.destroy', $order->id) . '"><i class="fa-solid fa-trash"></i></a>';

                    return '<div class="flex justify-evenly">
                        ' . $edit_btn . $info_btn . $invoice_generate_btn . $delete_btn . '
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();
        return view('backend.admin.order.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'product_ids' => 'required|array',
                'status' => 'required',
            ]);

            $auth_user = User::select('id', 'name')->find(auth()->guard('web')->user()->id);

            $order = Order::create([
                'orderable_type' => get_class($auth_user),
                'orderable_id' => $auth_user->id,
                'status' => $request->status,
                'order_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            $product_ids_ary = $request->product_ids;

            foreach ($product_ids_ary as $key => $value) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $value,
                    'quantity' => '',
                    'price' => '',
                ]);
            }


            DB::commit();
            return redirect()->route('admin.order.index')->with('success', 'Order created successfully');

        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
