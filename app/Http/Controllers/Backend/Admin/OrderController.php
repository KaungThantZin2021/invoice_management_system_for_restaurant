<?php

namespace App\Http\Controllers\Backend\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Invoice;
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
                    $edit_btn = '<a href="'. route('admin.order.edit', $order->id) .'" class="btn btn-sm btn-warning m-2"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $info_btn = '<a href="'. route('admin.order.show', $order->id) .'" class="btn btn-sm btn-primary m-2"><i class="fa-solid fa-circle-info"></i></a>';
                    $invoice_generate_btn = '<a href="'. route('admin.invoice.show', $order->id) .'" class="btn btn-sm btn-dark m-2"><i class="fa-solid fa-file-invoice"></i></a>';
                    $delete_btn = '<a href="#" class="btn btn-sm btn-danger text-light m-2 delete-btn" data-delete-url="' . route('admin.order.destroy', $order->id) . '"><i class="fa-solid fa-trash"></i></a>';

                    return '<div class="flex justify-evenly">
                        ' . $edit_btn . $info_btn . $invoice_generate_btn . $delete_btn . '
                    </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.admin.order.index');
    }

    public function show(Order $order)
    {
        return view('backend.admin.order.show', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateInvoice(Order $order)
    {
        try {
            $order = Order::with('order_items')->find($order->id);

            $invoice = Invoice::firstOrCreate([
                'order_id' => $order->id,
                'invoiceable_type' => $order->orderable_type,
                'invoiceable_id' => $order->orderable_id
            ], [
                'invoice_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                'total_amount' => $order->order_items->sum('price'),
                'tax' => 0
            ]);

            return success(['invoice_id' => $invoice->id]);

        } catch (Exception $e) {
            Log::info($e);
            return errorMessage($e->getMessage());
        }
    }
}
