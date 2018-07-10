<?php

namespace Modules\Carts\Http\Requests\Api;

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
        return [
            'post_id' => [
                'required', 'integer',
                Rule::exists('posts', 'id')->where(function ($query) {
                    $query->where('type', 'product');
                }),
            ],
            'quantity' => ['required', 'integer'],
        ];
    }
}
