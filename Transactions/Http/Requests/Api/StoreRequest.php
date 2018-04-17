<?php

namespace Modules\Transactions\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Users\Models\Users;

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
            'sender_id' => [
                'required', 'integer', 'digits_between:1,20',
                Rule::exists((new Users)->getTable(), 'id'),
            ],
            'balance' => [
                'integer',
                new \Modules\Users\Rules\BalanceCheck(['id' => \Auth::user()->id]),
            ],
            'transaction_details' => ['required'],
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
