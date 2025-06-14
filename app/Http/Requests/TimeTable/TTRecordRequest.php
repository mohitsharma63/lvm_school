<?php

namespace App\Http\Requests\TimeTable;

use Illuminate\Foundation\Http\FormRequest;

class TTRecordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'my_class_id' => 'required|exists:my_classes,id',
            'exam_id' => 'sometimes|nullable|exists:exams,id',
            'school_branch_id' => 'required|exists:school_branches,id',
        ];
    }

    public function attributes()
    {
        return  [
            'my_class_id' => 'Class',
        ];
    }

}
