@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="mb-4">
                    @include('components.back-button')
                    <a href="{{ route('admin.admin-user.create') }}" class="btn btn-success text-light"><i class="fa-solid fa-plus"></i> Create</a>
                </div>
                <div class="card">
                    <h5 class="card-header">Admin User</h5>
                    <div class="card-body">
                        <table class="table" id="adminUsersTable">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Profile Image</th>
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
        var table = $('#adminUsersTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: '{{ route("admin.admin-user.index") }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'profile_image', name: 'profile_image' },
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
