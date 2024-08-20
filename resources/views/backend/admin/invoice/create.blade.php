@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="mb-4">
                    <button type="button" class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i> Back</button>
                </div>
                <div class="card">
                    <h5 class="card-header">Create Order</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.order.store') }}" enctype="multipart/form-data" class="row g-3">
                            @csrf

                            @include('backend.admin.layouts.flash')

                            <div class="col-md-12">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-select" name="product_ids[]" multiple>
                                    <option value="">--- Please choose ---</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">--- Please choose ---</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirm">Confirm</option>
                                    <option value="cancel">Cancel</option>
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Cancel</a>
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

</script>
@endsection
