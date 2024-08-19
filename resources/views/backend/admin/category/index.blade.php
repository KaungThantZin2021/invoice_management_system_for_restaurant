@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="mb-4">
                    <button type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i> Back</button>
                    <a href="{{ route('admin.category.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Create</a>
                </div>
                <div class="card">
                    <h5 class="card-header">Category</h5>
                    <div class="card-body">
                        <table class="table" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated at</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                <tr>

                                </tr>

                            </tbody> --}}
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
        $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: '{{ route('admin.category.index') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'image', name: 'image' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                // { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
    </script>
@endsection
