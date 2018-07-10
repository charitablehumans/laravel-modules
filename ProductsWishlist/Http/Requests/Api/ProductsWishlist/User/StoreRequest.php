<?php

namespace Modules\ProductsWishlist\Http\Requests\Api\ProductsWishlist\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Products\Models\Products;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $post = new Products;

        return [
            'product_id' => [
                'required', 'integer',
                Rule::exists($post->getTable(), 'id')->where(function ($query) use ($post) {
                    $query->where('type', $post->type);
                })
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
