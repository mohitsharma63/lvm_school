<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolBranch\SchoolBranchCreate;
use App\Http\Requests\SchoolBranch\SchoolBranchUpdate;
use App\Repositories\SchoolBranchRepo;
use Illuminate\Support\Str;

class SchoolBranchController extends Controller
{
    protected $school_branch;

    public function __construct(SchoolBranchRepo $school_branch)
    {
        $this->school_branch = $school_branch;
    }

    public function index()
    {
        $d['branches'] = $this->school_branch->all();
        return view('pages.super_admin.school_branches.index', $d);
    }

    public function store(SchoolBranchCreate $req)
    {
        $data = $req->all();

        // Generate code if not provided
        if (empty($data['code'])) {
            $data['code'] = Str::slug($data['name']);
        }

        // Handle logo upload
        if ($req->hasFile('logo')) {
            $logo = $req->file('logo');
            $f = Qs::getFileMetaData($logo);
            $f['name'] = 'branch_logo_' . time() . '.' . $f['ext'];
            $f['path'] = $logo->storeAs(Qs::getPublicUploadPath(), $f['name']);
            $data['logo'] = asset('storage/' . $f['path']);
        }

        $this->school_branch->create($data);
        return back()->with('flash_success', __('msg.store_ok'));
    }

    public function show($id)
    {
        $d['branch'] = $this->school_branch->find($id);
        return view('pages.super_admin.school_branches.show', $d);
    }

    public function edit($id)
    {
        $d['branch'] = $this->school_branch->find($id);
        return view('pages.super_admin.school_branches.edit', $d);
    }

    public function update(SchoolBranchUpdate $req, $id)
    {
        $data = $req->all();

        // Handle logo upload
        if ($req->hasFile('logo')) {
            $logo = $req->file('logo');
            $f = Qs::getFileMetaData($logo);
            $f['name'] = 'branch_logo_' . time() . '.' . $f['ext'];
            $f['path'] = $logo->storeAs(Qs::getPublicUploadPath(), $f['name']);
            $data['logo'] = asset('storage/' . $f['path']);
        }

        $this->school_branch->update($id, $data);
        return back()->with('flash_success', __('msg.update_ok'));
    }

    public function destroy($id)
    {
        $this->school_branch->delete($id);
        return back()->with('flash_success', __('msg.del_ok'));
    }
}
