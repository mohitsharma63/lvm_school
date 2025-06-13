@extends('layouts.master')
@section('page_title', 'Manage School Branches')
@php use Illuminate\Support\Str; @endphp

@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">School Branches</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#add-branch" class="nav-link active" data-toggle="tab">Add Branch</a></li>
            <li class="nav-item"><a href="#manage-branches" class="nav-link" data-toggle="tab">Manage Branches</a></li>
        </ul>

        <div class="tab-content">
            {{-- Add Branch --}}
            <div class="tab-pane fade show active" id="add-branch">
                <div class="row">
                    <div class="col-md-8">
                        <form class="ajax-store" enctype="multipart/form-data" method="post" action="{{ route('school_branches.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Branch Name <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="name" value="{{ old('name') }}" required type="text" class="form-control" placeholder="Branch Name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Branch Code</label>
                                <div class="col-lg-9">
                                    <input name="code" value="{{ old('code') }}" type="text" class="form-control" placeholder="Branch Code (auto-generated if empty)">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Address <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <textarea name="address" required class="form-control" rows="3" placeholder="Branch Address">{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Phone</label>
                                <div class="col-lg-9">
                                    <input name="phone" value="{{ old('phone') }}" type="text" class="form-control" placeholder="Phone Number">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Email</label>
                                <div class="col-lg-9">
                                    <input name="email" value="{{ old('email') }}" type="email" class="form-control" placeholder="Email Address">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Description</label>
                                <div class="col-lg-9">
                                    <textarea name="description" class="form-control" rows="3" placeholder="Branch Description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Logo</label>
                                <div class="col-lg-9">
                                    <input name="logo" accept="image/*" type="file" class="form-control-plaintext file-input" data-show-caption="false" data-show-upload="false" data-fouc>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Status</label>
                                <div class="col-lg-9">
                                    <select class="form-control select" name="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Manage Branches --}}
            <div class="tab-pane fade" id="manage-branches">
                <table class="table datatable-button-html5-columns">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($branches as $branch)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($branch->logo)
                                    <img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $branch->logo }}" alt="">
                                @else
                                    <span class="badge badge-secondary">No Logo</span>
                                @endif
                            </td>
                            <td>{{ $branch->name }}</td>
                            <td>{{ $branch->code }}</td>
                            <td>{{ Str::limit($branch->address, 50) }}</td>
                            <td>{{ $branch->phone }}</td>
                            <td>
                                @if($branch->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a href="{{ route('school_branches.show', $branch->id) }}" class="dropdown-item"><i class="icon-eye"></i> View</a>
                                            <a href="{{ route('school_branches.edit', $branch->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                            <a id="{{ $branch->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                            <form method="post" id="item-delete-{{ $branch->id }}" action="{{ route('school_branches.destroy', $branch->id) }}" class="hidden">@csrf @method('delete')</form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
