@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="mb-4">
                    @include('components.back-button')
                </div>
                <div class="card">
                    <h5 class="card-header">Create Product</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data" class="row g-3">
                            @csrf

                            @include('backend.admin.layouts.flash')

                            <div class="col-md-12">
                                <label for="name" class="form-label">Category</label>
                                <select class="form-select" name="category_id">
                                    <option value="">--- Please choose ---</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" name="image" id="image">
                            </div>
                            <div class="col-md-12">
                                <div id="imagePreview" class="col-md-6" style="display: none;">
                                    <p>Preview:</p>
                                    <img id="previewImage" src="#" alt="Image Preview" style="max-width: 300px; max-height: 300px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" class="form-control" id="price">
                            </div>
                            <div class="col-md-6">
                                <label for="stockQuantity" class="form-label">Stock Quantity</label>
                                <input type="number" name="stock_quantity" class="form-control" id="stockQuantity">
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $('#image').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#previewImage').attr('src', e.target.result);
                $('#imagePreview').show();
            };
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@endsection
