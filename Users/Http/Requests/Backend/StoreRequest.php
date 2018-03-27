<?php

namespace Modules\Users\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $rules['name'] = ['required', 'between:0,191'];
        $rules['email'] = [
            'required', 'between:0,191', 'email',
            Rule::unique('users', 'email'),
        ];
        $rules['phone_number'] = [
            'required', 'between:0,20',
            Rule::unique('users', 'phone_number'),
        ];
        $rules['password'] = ['between:0,191'];
        $rules['verification_code'] = ['digits:6'];
        $rules['date_of_birth'] = ['required', 'date'];
        $rules['address'] = ['required'];
        config('cms.users.balance') ? $rules['balance'] = ['numeric'] : '';
        config('cms.users.game_token') ? $rules['game_token'] = ['numeric'] : '';

        return $rules;
    }
}
