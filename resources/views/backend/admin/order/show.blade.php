@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Order Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Orderable</label>
                                    <p>{{ optional($order->orderable)->name }} ({{ class_basename($order->orderable) }})</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Status</label>
                                    <p>
                                        @if ($order->isPending())
                                            <span class="badge text-bg-warning">{{ ucfirst($order->status) }}</span>
                                        @elseif ($order->isConfirm())
                                            <span
                                                class="badge text-bg-success text-light">{{ ucfirst($order->status) }}</span>
                                        @elseif ($order->isCancel())
                                            <span
                                                class="badge text-bg-danger text-light">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Order Datetime</label>
                                    <p>{{ $order->order_datetime }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Created at</label>
                                    <p>{{ $order->created_at }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Updated at</label>
                                    <p>{{ $order->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <h5 class="card-header">
                        <span>Order Items</span>
                        @if ($order->isPending())
                        <button class="btn btn-danger btn-sm text-light float-end ms-1" type="button"><i class="fa-solid fa-xmark"></i> Order Cancel</button>
                        <button class="btn btn-success btn-sm text-light float-end ms-1" type="button"><i class="fa-solid fa-check"></i> Order Confirm</button>
                        @elseif ($order->isConfirm())
                        <button class="btn btn-dark btn-sm float-end ms-1 generate-invoice" data-order-id="{{ $order->id }}" type="button"><i class="fas fa-file-invoice"></i> Generate Invoice</button>
                        @endif
                    </h5>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Product Price</th>
                                            <th scope="col">Qunatity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->order_items as $key => $order_item)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $order_item->product->name }}</td>
                                                <td>{{ number_format($order_item->product->price) }} MMK</td>
                                                <td>{{ number_format($order_item->quantity) }}</td>
                                                <td>{{ number_format($order_item->price) }} MMK</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="fw-medium text-center">Total</td>
                                            <td class="fw-medium">{{ number_format($order->order_items->sum('quantity')) }}</td>
                                            <td class="fw-medium">{{ number_format($order->order_items->sum('price')) }} MMK</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <div>
                                    @php
                                        $order_items = $order->order_items;

                                        $total_product = $order_items->count();
                                        $total_price = $order_items->sum('price');
                                        $total_quantity = $order_items->sum('quantity');
                                        $tax = 0;
                                        $total_amount = number_format($total_price + $tax);
                                    @endphp
                                    <ol class="list-group total-cart-item-lists-area">
                                        <li class="list-group-item align-items-start">
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-bold">Total Product</div>
                                                <div>{{ $total_product }}</div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-bold">Total Quntity</div>
                                                <div>{{ $total_quantity }}</div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-bold">Total Price</div>
                                                <div>{{ $total_price }} MMK</div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-bold">Tax</div>
                                                <div>{{ $tax }}</div>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <div class="fw-bold">Total Amount</div>
                                                <div>{{ $total_amount }} MMK</div>
                                            </div>
                                        </li>
                                    </ol>
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
            $(document).on('click', '.generate-invoice', function() {
                var order_id = $(this).data('order-id');

                Swal.fire({
                    title: "Are you sure to <br>generate invoice?",
                    showCancelButton: true,
                    confirmButtonColor: "#4b49b6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: "Generating...!",
                            html: "Please wait",
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.post(`/admin/order/${order_id}/generate-invoice`,)
                            .then(function(res) {
                                if (res.success) {
                                    setTimeout(() => {
                                        window.location.href = `/admin/invoice`;
                                    }, 1000);
                                } else {
                                    toastr.warning(res.message);
                                }
                            }).fail(function(error) {
                                toastr.error(error.message);
                            });
                    }
                });
            });
        });
    </script>
@endsection
