@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="mb-4">
                    @include('components.back-button')
                </div>
                <div class="card">
                    <h5 class="card-header">Invoice</h5>
                    <div class="card-body">
                        <table class="table" id="invoicesTable">
                            <thead>
                                <tr>
                                    <th scope="col">Invoice No.</th>
                                    <th scope="col">Order No.</th>
                                    <th scope="col">Invoiceable</th>
                                    <th scope="col">Invoice Datetime</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Tax</th>
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
        var table = $('#invoicesTable').DataTable({
            ajax: '{{ route("admin.invoice.index") }}',
            columns: [
                { data: 'invoice_number', name: 'invoice_number' },
                { data: 'order_number', name: 'order_number' },
                { data: 'invoiceable', name: 'invoiceable' },
                { data: 'invoice_datetime', name: 'invoice_datetime' },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'tax', name: 'tax' },
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
