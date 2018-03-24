<?php

namespace Modules\Permissions\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'digits_between:1,10'],
            'name' => ['required', 'between:0,191', 'unique:permissions,name,'.$this->input('id')],
            'guard_name' => ['required', 'between:0,191'],
        ];
    }
}
