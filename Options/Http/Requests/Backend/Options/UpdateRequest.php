<?php

namespace Modules\Options\Http\Requests\Backend\Options;

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
            'name' => ['required', 'between:0,191', 'unique:options,name,'.$this->input('id')],
        ];
    }
}
