@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="mb-4">
                    @include('components.back-button')
                </div>
                <div class="card">
                    <h5 class="card-header">Edit Category</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.category.update', $category->id) }}" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('PUT')

                            @include('backend.admin.layouts.flash')

                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $category->name }}" id="name">
                            </div>
                            <div class="col-md-12">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" name="image" id="image">
                            </div>
                            <div id="imagePreview" class="col-md-6" style="display: {{ !$category->image ? 'none' : '' }};">
                                <p>Preview:</p>
                                <img id="previewImage" src="{{ $category->image_url }}" alt="Image Preview" style="max-width: 300px; max-height: 300px;">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
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
