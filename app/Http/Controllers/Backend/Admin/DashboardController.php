<?php

namespace App\Http\Controllers\Backend\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::query();

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

        return view('backend.admin.dashboard.index', compact('order_status_count_ary', 'products_stock_quantity_ary'));
    }

    public function getOrderChartData(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new Exception('Invalid request!');
            }

            $start_of = Carbon::now()->startOfWeek();
            $end_of = Carbon::now()->endOfWeek();

            if ($request->chart_current_duration == 'monthly') {
                $start_of = Carbon::now()->startOfMonth();
                $end_of = Carbon::now()->endOfMonth();
            }

            $order_counts = Order::whereBetween('created_at', [$start_of, $end_of])
                            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();

            $order_revenues = Order::whereBetween('orders.created_at', [$start_of, $end_of])
                            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                            ->selectRaw('DATE(orders.created_at) as date, SUM(order_items.price) as revenue')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();

            $dates = [];
            $counts = [];
            $total_counts = 0;
            $revenues = [];
            $total_revenues = 0;

            $current_date = $start_of->copy();

            while ($current_date->lte($end_of)) {
                $formatted_date = $current_date->format('Y-m-d');
                $dates[] = $formatted_date;

                $order_count = $order_counts->firstWhere('date', $formatted_date);
                $counts[] = $order_count ? $order_count->count : 0;
                $total_counts += $order_count ? $order_count->count : 0;

                $order_revenue = $order_revenues->firstWhere('date', $formatted_date);
                $revenues[] = $order_revenue ? $order_revenue->revenue : 0;
                $total_revenues += $order_revenue ? $order_revenue->revenue : 0;

                $current_date->addDay();
            }

            $orders_ary = [
                'dates' => $dates,
                'counts' => $counts,
                'total_counts' => number_format($total_counts),
                'revenues' => $revenues,
                'total_revenues' => number_format($total_revenues) . ' ' . __('message.mmk'),
            ];

            return success($orders_ary);

        } catch (Exception $e) {
            Log::error($e);
            return errorMessage($e->getMessage());
        }
    }
}
