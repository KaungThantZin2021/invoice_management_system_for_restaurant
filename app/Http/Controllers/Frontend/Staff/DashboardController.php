<?php

namespace App\Http\Controllers\Frontend\Staff;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('orderable_type', Staff::class)->where('orderable_id', auth()->guard('staff')->user()->id);

        $pending_order_count = $orders->pending()->count();
        $confirm_order_count = $orders->confirm()->count();
        $cancel_order_count = $orders->cancel()->count();

        $order_status_count_ary = [
            $pending_order_count,
            $confirm_order_count,
            $cancel_order_count
        ];

        $products = Product::select('name', 'stock_quantity');

        $products_stock_quantity_ary = [
            'name' => $products->pluck('name'),
            'stock_quantity' => $products->pluck('stock_quantity')
        ];

        return view('frontend.staff.dashboard.index', compact('order_status_count_ary', 'products_stock_quantity_ary'));
    }

    public function getOrderChartData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new Exception('invalid request!');
            }

            $startOf = Carbon::now()->startOfWeek();
            $endOf = Carbon::now()->endOfWeek();

            if ($request->chart_current_duration == 'monthly') {
                $startOf = Carbon::now()->startOfMonth();
                $endOf = Carbon::now()->endOfMonth();
            }

            $orderCounts = Order::where('orderable_type', Staff::class)
                                ->where('orderable_id', auth()->guard('staff')->user()->id)
                                ->whereBetween('created_at', [$startOf, $endOf])
                                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                ->groupBy('date')
                                ->orderBy('date')
                                ->get();

            $dates = [];
            $counts = [];

            $currentDate = $startOf->copy();

            while ($currentDate->lte($endOf)) {
                $formattedDate = $currentDate->format('Y-m-d');
                $dates[] = $formattedDate;

                $orderCount = $orderCounts->firstWhere('date', $formattedDate);
                $counts[] = $orderCount ? $orderCount->count : 0;

                $currentDate->addDay();
            }

            $orders_ary = [
                'dates' => $dates,
                'counts' => $counts
            ];

            return success($orders_ary);

        } catch (Exception $e) {
            Log::error($e);
            return errorMessage($e->getMessage());
        }
    }
}
