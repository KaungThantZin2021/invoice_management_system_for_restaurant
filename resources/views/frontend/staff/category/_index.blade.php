@extends('frontend.staff.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div id="app">
                    <product-list></product-list>
                </div>


                {{-- <div class="mb-4">
                    <button type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i> Back</button>
                    <a href="{{ route('category.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Create</a>
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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
