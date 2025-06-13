
@extends('layouts.master')
@section('page_title', 'Edit School Branch')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Edit School Branch - {{ $branch->name }}</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <form enctype="multipart/form-data" method="post" action="{{ route('school_branches.update', $branch->id) }}">
                    @csrf @method('PUT')

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Branch Name <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="name" value="{{ $branch->name }}" required type="text" class="form-control" placeholder="Branch Name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Branch Code</label>
                        <div class="col-lg-9">
                            <input name="code" value="{{ $branch->code }}" type="text" class="form-control" placeholder="Branch Code">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Address <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <textarea name="address" required class="form-control" rows="3" placeholder="Branch Address">{{ $branch->address }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Phone</label>
                        <div class="col-lg-9">
                            <input name="phone" value="{{ $branch->phone }}" type="text" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Email</label>
                        <div class="col-lg-9">
                            <input name="email" value="{{ $branch->email }}" type="email" class="form-control" placeholder="Email Address">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Description</label>
                        <div class="col-lg-9">
                            <textarea name="description" class="form-control" rows="3" placeholder="Branch Description">{{ $branch->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Current Logo</label>
                        <div class="col-lg-9">
                            @if($branch->logo)
                                <img style="width: 100px; height: 100px;" src="{{ $branch->logo }}" alt="Current Logo" class="mb-2">
                            @else
                                <p class="text-muted">No logo uploaded</p>
                            @endif
                            <input name="logo" accept="image/*" type="file" class="form-control-plaintext file-input" data-show-caption="false" data-show-upload="false" data-fouc>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Status</label>
                        <div class="col-lg-9">
                            <select class="form-control select" name="is_active">
                                <option {{ $branch->is_active ? 'selected' : '' }} value="1">Active</option>
                                <option {{ !$branch->is_active ? 'selected' : '' }} value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Branch <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
