<?php

namespace Modules\UserAddresses\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', 'digits_between:1,20', 'exists:users,id'],
            'name' => ['required', 'between:0,191'],
            'phone_number' => ['required', 'between:0,20'],
            'province_id' => ['required', 'integer', 'digits_between:1,20'],
            'regency_id' => ['required', 'integer', 'digits_between:1,20'],
            'district_id' => ['required', 'integer', 'digits_between:1,20'],
            'postal_code' => ['required', 'between:0,10'],
            'address' => ['required'],
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
