<?php

namespace Modules\TransactionDetails\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'quantity' => ['required', 'integer', 'digits_between:0,20'],
            'product_id' => [
                'required', 'integer', 'digits_between:0,20',
                Rule::exists('posts', 'id')->where(function ($query) {
                    $query->where('type', 'product');
                }),
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
