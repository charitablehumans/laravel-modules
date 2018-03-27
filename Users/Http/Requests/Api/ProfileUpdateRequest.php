<?php

namespace Modules\Users\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'email' => [
                'required', 'between:0,191', 'email',
                Rule::unique('users', 'email')->ignore(Auth::user()->id),
            ],
            'phone_number' => [
                'required', 'between:0,20',
                Rule::unique('users', 'phone_number')->ignore(Auth::user()->id),
            ],
            'password' => ['between:0,191'], 
            'date_of_birth' => ['required', 'date'],
            'address' => ['required'],
        ];
    }
}
