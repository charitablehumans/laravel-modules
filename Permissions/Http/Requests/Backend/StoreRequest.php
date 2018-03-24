<?php

namespace Modules\Permissions\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'between:0,191', 'unique:permissions,name'],
            'guard_name' => ['required', 'between:0,191'],
        ];
    }
}
