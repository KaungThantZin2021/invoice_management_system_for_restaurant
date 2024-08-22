@extends('frontend.staff.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    @php
                        $order = optional($invoice->order);
                        $order_items = $order->order_items;

                        $total_product = $order_items->count();
                        $total_price = $order_items->sum('price');
                        $total_quantity = $order_items->sum('quantity');
                        $tax = 0;
                        $total_amount = $total_price + $tax;
                    @endphp
                    <h5 class="card-header">Invoice Detail</h5>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-5">
                                <ol class="list-group mt-2">
                                    <li class="list-group-item align-items-start">
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold">Invoice Number</div>
                                            <div>{{ $invoice->invoice_number }}</div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold">Order Number</div>
                                            <div>{{ $order->order_number }}</div>
                                        </div>
                                    </li>
                                </ol>
                                <ol class="list-group mt-2">
                                    @foreach ($order_items as $key => $order_item)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="w-1/2">
                                            <div>{{ $key + 1 }}. <span class="fw-bold">{{ $order_item->product->name }}</span></div>
                                        </div>
                                        <span class="">{{ number_format($order_item->quantity) }}</span>
                                        <span class="">{{ number_format($order_item->price) }} MMK</span>
                                    </li>
                                    @endforeach
                                </ol>
                                <ol class="list-group mt-2">
                                    <li class="list-group-item align-items-start">
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold">Total Product</div>
                                            <div>{{ number_format($total_product) }}</div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold">Total Quntity</div>
                                            <div>{{ number_format($total_quantity) }}</div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold">Total Price</div>
                                            <div>{{ number_format($total_price) }} MMK</div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold">Tax</div>
                                            <div>{{ number_format($tax) }} MMK</div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <div class="fw-bold">Total Amount</div>
                                            <div>{{ number_format($total_amount) }} MMK</div>
                                        </div>
                                    </li>
                                </ol>

                                <div class="d-grid my-3">
                                    <a href="{{ route('admin.invoice.download', $invoice->id) }}" target="_black" class="btn btn-dark" type="button"><i class="fa-solid fa-file-arrow-down"></i> Download Invoice</a>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@endsection
