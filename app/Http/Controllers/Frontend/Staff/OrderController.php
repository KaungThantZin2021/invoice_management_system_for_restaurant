<?php

namespace App\Http\Controllers\Frontend\Staff;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function orderConfirm(Request $request, $id)
    {
        try {
            if (!$request->ajax()) {
                throw new Exception('Invalid request!');
            }

            $order = Order::where('user_id', auth()->guard('staff')->user()->id)->pending()->find($id);

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
}
