<?php

namespace App\Http\Requests\SchoolBranch;

use Illuminate\Foundation\Http\FormRequest;

class SchoolBranchUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('school_branch');

        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:school_branches,code,'.$id,
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
