<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'myanmar';
        }


    </style>
</head>
<body>
    @php
        $order = optional($invoice->order);
        $order_items = $order->order_items;

        $total_product = $order_items->count();
        $total_price = $order_items->sum('price');
        $total_quantity = $order_items->sum('quantity');
        $tax = 0;
        $total_amount = $total_price + $tax;
    @endphp
    <div class="card">
        <div class="card-body">
            <ol class="list-group mt-2">
                <li class="list-group-item align-items-start">
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">{{ __('message.invoice_number') }}</div>
                        <div class="total-amount">{{ $invoice->invoice_number }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">{{ __('message.order_number') }}</div>
                        <div class="total-amount">{{ $order->order_number }}</div>
                    </div>
                </li>
            </ol>
            <ol class="list-group list-group-numbered mt-2">
                @foreach ($order_items as $key => $order_item)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="w-1/2">
                        <div>{{ $key + 1 }}. <span class="fw-bold">{{ $order_item->product->name }}</span></div>
                    </div>
                    <span class="">{{ number_format($order_item->quantity) }}</span>
                    <span class="">{{ number_format($order_item->price) }} {{ __('message.mmk') }}</span>
                </li>
                @endforeach
            </ol>
            <ol class="list-group mt-2">
                <li class="list-group-item align-items-start">
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">{{ __('message.total_product') }}</div>
                        <div>{{ number_format($total_product) }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">{{ __('message.total_quantity') }}</div>
                        <div>{{ number_format($total_quantity) }}</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">{{ __('message.total_price') }}</div>
                        <div>{{ number_format($total_price) }} {{ __('message.mmk') }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">{{ __('message.tax') }}</div>
                        <div>{{ number_format($tax) }} {{ __('message.mmk') }}</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">{{ __('message.total_amount') }}</div>
                        <div>{{ number_format($total_amount) }} {{ __('message.mmk') }}</div>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</body>
</html>
