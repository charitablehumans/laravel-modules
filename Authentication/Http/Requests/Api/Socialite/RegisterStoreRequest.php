<?php

namespace Modules\Authentication\Http\Requests\Api\Socialite;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider' => ['required'],
            'id' => ['required'],
            'email' => ['required', 'between:0,191', 'email'],
            'name' => ['required'],
            'user' => ['required'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
