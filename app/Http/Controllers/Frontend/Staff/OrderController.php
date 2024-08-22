<?php

namespace App\Http\Controllers\Frontend\Staff;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Staff;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::where('orderable_type', Staff::class)->where('orderable_id', auth()->guard('staff')->user()->id);

            return DataTables::of($orders)
                ->addColumn('orderable', function ($order) {
                    return optional($order->orderable)->name . ' (' . class_basename($order->orderable) . ')';
                })
                ->addColumn('status', function ($order) {
                    $status = '';
                    if ($order->isPending()) {
                        $status = '<span class="badge text-bg-warning">' . ucfirst($order->status) . '</span>';
                    } elseif ($order->isConfirm()) {
                        $status = '<span class="badge text-bg-success text-light">' . ucfirst($order->status) . '</span>';
                    } elseif ($order->isCancel()) {
                        $status = '<span class="badge text-bg-danger text-light">' . ucfirst($order->status) . '</span>';
                    }

                    return $status;
                })
                ->addColumn('action', function ($order) {
                    $info_btn = '<a href="'. route('order.show', $order->id) .'" class="btn btn-sm btn-primary m-2"><i class="fa-solid fa-circle-info"></i></a>';
                    $invoice_generate_btn = '<a href="'. route('admin.invoice.show', $order->id) .'" class="btn btn-sm btn-info text-light m-2"><i class="fa-solid fa-file-invoice"></i></a>';
                    $delete_btn = '<a href="#" class="btn btn-sm btn-danger text-light m-2 delete-btn" data-delete-url="' . route('admin.order.destroy', $order->id) . '"><i class="fa-solid fa-xmark"></i></a>';

                    return '<div class="flex justify-evenly">
                        ' . $info_btn . $invoice_generate_btn . $delete_btn . '
                    </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('frontend.staff.order.index');
    }

    public function orderConfirm(Request $request, $id)
    {
        try {
            if (!$request->ajax()) {
                throw new Exception('Invalid request!');
            }

            $order = Order::where('orderable_type', Staff::class)
                ->where('orderable_id', auth()->guard('staff')->user()->id)
                ->pending()
                ->whereNull('order_datetime')
                ->find($id);

            if(!$order) {
                throw new Exception('Order not found!');
            }

            $order->status = 'confirm';
            $order->order_datetime = Carbon::now()->format('Y-m-d H:i:s');
            $order->update();

            return successMessage('Order confirmed successfully!');
        } catch (Exception $e) {
            return errorMessage($e->getMessage());
        }
    }

    public function orderCancel(Request $request, $id)
    {
        try {
            if (!$request->ajax()) {
                throw new Exception('Invalid request!');
            }

            $order = Order::where('orderable_type', Staff::class)
                ->where('orderable_id', auth()->guard('staff')->user()->id)
                ->pending()
                ->whereNull('order_datetime')
                ->find($id);

            if(!$order) {
                throw new Exception('Order not found!');
            }

            if(isset($order->order_items)) {
                $order->order_items()->delete();
            }

            $order->status = 'cancel';
            $order->update();

            return successMessage('Order canceled successfully!');
        } catch (Exception $e) {
            return errorMessage($e->getMessage());
        }
    }

    public function show(Order $order)
    {
        return view('frontend.staff.order.show', compact('order'));
    }
}
