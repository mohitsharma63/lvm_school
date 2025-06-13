<?php

namespace App\Repositories;

use App\Models\SchoolBranch;

class SchoolBranchRepo
{
    public function create($data)
    {
        return SchoolBranch::create($data);
    }

    public function all()
    {
        return SchoolBranch::orderBy('name')->get();
    }

    public function find($id)
    {
        return SchoolBranch::find($id);
    }

    public function update($id, $data)
    {
        return SchoolBranch::find($id)->update($data);
    }

    public function delete($id)
    {
        return SchoolBranch::find($id)->delete();
    }

    public function getActive()
    {
        return SchoolBranch::where('is_active', true)->orderBy('name')->get();
    }

    public function findByCode($code)
    {
        return SchoolBranch::where('code', $code)->first();
    }
}
