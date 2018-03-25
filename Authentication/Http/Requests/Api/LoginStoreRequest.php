<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginStoreRequest extends FormRequest
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
            'email' => ['required', 'between:0,191', 'email'],
            'password' => ['required', 'between:0,191'],
        ];
    }
}
