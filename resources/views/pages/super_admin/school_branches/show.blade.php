
@extends('layouts.master')
@section('page_title', 'School Branch Details')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">School Branch Details - {{ $branch->name }}</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Branch Name</th>
                        <td>{{ $branch->name }}</td>
                    </tr>
                    <tr>
                        <th>Branch Code</th>
                        <td>{{ $branch->code }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $branch->address }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $branch->phone ?: 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $branch->email ?: 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $branch->description ?: 'No description' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($branch->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ $branch->created_at->format('M d, Y - h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $branch->updated_at->format('M d, Y - h:i A') }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                @if($branch->logo)
                    <div class="text-center">
                        <h6>Branch Logo</h6>
                        <img style="width: 200px; height: 200px; object-fit: contain;" src="{{ $branch->logo }}" alt="Branch Logo" class="img-thumbnail">
                    </div>
                @else
                    <div class="text-center">
                        <h6>No Logo</h6>
                        <div class="bg-light p-4">
                            <i class="icon-image2 text-muted" style="font-size: 48px;"></i>
                            <p class="text-muted mt-2">No logo uploaded</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-right mt-3">
            <a href="{{ route('school_branches.edit', $branch->id) }}" class="btn btn-primary">Edit Branch <i class="icon-pencil ml-2"></i></a>
            <a href="{{ route('school_branches.index') }}" class="btn btn-secondary">Back to List <i class="icon-arrow-left8 ml-2"></i></a>
        </div>
    </div>
</div>

@endsection
