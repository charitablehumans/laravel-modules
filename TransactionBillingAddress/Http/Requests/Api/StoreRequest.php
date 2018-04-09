<?php

namespace Modules\TransactionBillingAddress\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\UserAddresses\Models\UserAddresses;

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
            'user_address_id' => [
                'required', 'integer', 'between:0,20',
                Rule::exists((new UserAddresses)->getTable(), 'id'),
            ],
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
