<script src="{{ asset('jquery/jquery-3.7.1.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (document.getElementById('backBtn')) {
            document.getElementById('backBtn').onclick = function () {
                window.history.back();
            };
        }

        $.extend(true, $.fn.dataTable.defaults, {
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="fa-solid fa-sync"></i>',
                    className: 'btn btn-sm btn-dark m-0',
                    action: function (e, dt, node, config) {
                        dt.ajax.reload(); // Reload the table data
                    }
                }
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
        });
    });
</script>

{{-- <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.4/b-3.1.1/b-colvis-3.1.1/b-html5-3.1.1/b-print-3.1.1/r-3.0.2/datatables.min.js"></script>

