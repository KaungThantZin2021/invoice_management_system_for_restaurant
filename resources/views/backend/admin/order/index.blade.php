@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="mb-4">
                    @include('components.back-button')
                    <a href="{{ route('admin.order.add-to-cart.form') }}" class="btn btn-success text-light"><i class="fa-solid fa-plus"></i> Create a order</a>
                </div>
                <div class="card">
                    <h5 class="card-header">Order</h5>
                    <div class="card-body">
                        <table class="table" id="orderTable">
                            <thead>
                                <tr>
                                    <th scope="col">Order No.</th>
                                    <th scope="col">Orderable</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Order Datetime</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#orderTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: '{{ route("admin.order.index") }}',
            columns: [
                { data: 'order_number', name: 'order_number' },
                { data: 'orderable', name: 'orderable' },
                { data: 'status', name: 'status' },
                { data: 'order_datetime', name: 'order_datetime' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $(document).on('click', '.delete-btn', function(e){
            e.preventDefault();

            let deleteUrl = $(this).data('delete-url');

            Swal.fire({
                title: "Are you sure to delete?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(deleteUrl, {
                        '_method': 'DELETE'
                    })
                    .then(function(res) {
                        if (res.success == 1) {
                            table.ajax.reload();
                            toastr.success(res.message);
                        } else {
                            toastr.warning(res.message);
                        }
                    }).fail(function(error) {
                        toastr.error(res.message);
                    });
                }
            });
        });
    });
    </script>
@endsection
