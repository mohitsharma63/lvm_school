
@extends('layouts.master')
@section('page_title', 'Manage TimeTables')
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Manage TimeTables</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                @if(Qs::userIsTeamSA())
                <li class="nav-item"><a href="#add-tt" class="nav-link active" data-toggle="tab">Create Timetable</a></li>
                @endif
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Show TimeTables</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($my_classes as $mc)
                            <a href="#ttr{{ $mc->id }}" class="dropdown-item" data-toggle="tab">{{ $mc->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item"><a href="#list-tt" class="nav-link" data-toggle="tab">All TimeTables</a></li>
            </ul>

            <div class="tab-content">

                @if(Qs::userIsTeamSA())
                <div class="tab-pane fade show active" id="add-tt">
                   <div class="col-md-8">
                       <form class="ajax-store" method="post" action="{{ route('ttr.store') }}">
                           @csrf
                           <div class="form-group row">
                               <label class="col-lg-3 col-form-label font-weight-semibold">Name <span class="text-danger">*</span></label>
                               <div class="col-lg-9">
                                   <input name="name" value="{{ old('name') }}" required type="text" class="form-control" placeholder="Name of TimeTable">
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="school_branch_id" class="col-lg-3 col-form-label font-weight-semibold">Branch <span class="text-danger">*</span></label>
                               <div class="col-lg-9">
                                   <select required data-placeholder="Select Branch" class="form-control select" name="school_branch_id" id="school_branch_id">
                                       <option value="">Select Branch</option>
                                       @foreach($branches as $branch)
                                           <option {{ old('school_branch_id') == $branch->id ? 'selected' : '' }} value="{{ $branch->id }}">{{ $branch->name }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="my_class_id" class="col-lg-3 col-form-label font-weight-semibold">Class <span class="text-danger">*</span></label>
                               <div class="col-lg-9">
                                   <select required data-placeholder="Select Class" class="form-control select" name="my_class_id" id="my_class_id">
                                       @foreach($my_classes as $mc)
                                           <option {{ old('my_class_id') == $mc->id ? 'selected' : '' }} value="{{ $mc->id }}">{{ $mc->name }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>

                           <div class="form-group row">
                               <label for="exam_id" class="col-lg-3 col-form-label font-weight-semibold">Type (Class or Exam)</label>
                               <div class="col-lg-9">
                                   <select class="select form-control" name="exam_id" id="exam_id">
                                       <option value="">Class Timetable</option>
                                       @foreach($exams as $ex)
                                           <option {{ old('exam_id') == $ex->id ? 'selected' : '' }} value="{{ $ex->id }}">{{ $ex->name }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>

                           <div class="text-right">
                               <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                           </div>
                       </form>
                   </div>
                </div>
                @endif

                {{-- List All TimeTables Tab --}}
                <div class="tab-pane fade" id="list-tt">
                    <div class="table-responsive">
                        <table class="table datatable-button-html5-columns">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Branch</th>
                                    <th>Type</th>
                                    <th>Year</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tt_records as $ttr)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ttr->name }}</td>
                                    <td>{{ $ttr->my_class->name }}</td>
                                    <td>{{ $ttr->schoolBranch->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($ttr->exam_id)
                                            <span class="badge badge-info">{{ $ttr->exam->name }}</span>
                                        @else
                                            <span class="badge badge-success">Class Timetable</span>
                                        @endif
                                    </td>
                                    <td>{{ $ttr->year }}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">

                                                    {{-- Edit --}}
                                                    @if(Qs::userIsTeamSA())
                                                    <a href="{{ route('ttr.edit', $ttr->id) }}" class="dropdown-item">
                                                        <i class="icon-pencil"></i> Edit
                                                    </a>
                                                    @endif
                                                    {{-- Delete --}}
                                                    @if(Qs::userIsTeamSA())
                                                    <a id="{{ $ttr->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item text-danger">
                                                        <i class="icon-trash"></i> Delete
                                                    </a>
                                                    <form method="post" id="item-delete-{{ $ttr->id }}" action="{{ route('ttr.destroy', $ttr->id) }}" class="hidden">@csrf @method('delete')</form>
                                                    @endif
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

                {{-- Show TimeTables by Class --}}
                @foreach($my_classes as $mc)
                    <div class="tab-pane fade" id="ttr{{ $mc->id }}">
                        <div class="table-responsive">
                            <table class="table datatable-button-html5-columns">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Year</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tt_records->where('my_class_id', $mc->id) as $ttr)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ttr->name }}</td>
                                        <td>
                                            @if($ttr->exam_id)
                                                <span class="badge badge-info">{{ $ttr->exam->name }}</span>
                                            @else
                                                <span class="badge badge-success">Class Timetable</span>
                                            @endif
                                        </td>
                                        <td>{{ $ttr->year }}</td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        {{-- View/Show --}}
                                                        <a href="{{ route('ttr.show', $ttr->id) }}" class="dropdown-item">
                                                            <i class="icon-eye"></i> View
                                                        </a>
                                                        {{-- Manage --}}
                                                        <a href="{{ route('ttr.manage', $ttr->id) }}" class="dropdown-item">
                                                            <i class="icon-plus22"></i> Manage
                                                        </a>
                                                        {{-- Edit --}}
                                                        @if(Qs::userIsTeamSA())
                                                        <a href="{{ route('ttr.edit', $ttr->id) }}" class="dropdown-item">
                                                            <i class="icon-pencil"></i> Edit
                                                        </a>
                                                        @endif
                                                        {{-- Delete --}}
                                                        @if(Qs::userIsTeamSA())
                                                        <a id="del-{{ $ttr->id }}" onclick="confirmDelete('del-{{ $ttr->id }}')" href="#" class="dropdown-item text-danger">
                                                            <i class="icon-trash"></i> Delete
                                                        </a>
                                                        <form method="post" id="item-delete-del-{{ $ttr->id }}" action="{{ route('ttr.destroy', $ttr->id) }}" class="hidden">@csrf @method('delete')</form>
                                                        @endif
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
                @endforeach

            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this timetable record? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    let deleteFormId = '';

    function confirmDelete(id) {
        deleteFormId = 'item-delete-' + id;
        $('#confirmDeleteModal').modal('show');
    }

    $(document).ready(function() {
        $('#confirmDeleteBtn').click(function() {
            $('#' + deleteFormId).submit();
        });
    });
</script>
