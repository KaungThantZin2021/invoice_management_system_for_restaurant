@extends('backend.admin.layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Admin User Detail</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Name</label>
                                    <p>{{ $admin_user->name }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Email</label>
                                    <p>{{ $admin_user->email }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Phone</label>
                                    <p>{{ $admin_user->phone }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Created at</label>
                                    <p>{{ $admin_user->created_at }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Updated at</label>
                                    <p>{{ $admin_user->updated_at }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="fw-semibold">Profile Image</label>
                                    <div>
                                        <img src="{{ $admin_user->profile_image_url }}" class="object-cover w-24 h-24"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
