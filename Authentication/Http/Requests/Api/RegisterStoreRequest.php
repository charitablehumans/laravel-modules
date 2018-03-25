<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStoreRequest extends FormRequest
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
            'name' => ['required', 'between:0,191'],
            'email' => ['required', 'between:0,191', 'email', 'unique:users'],
            'phone_number' => ['required', 'between:0,20', 'unique:users'],
            'password' => ['required', 'between:0,191'],
        ];
    }
}
