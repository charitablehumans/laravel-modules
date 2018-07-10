<?php

namespace Modules\ProductsWishlist\Http\Requests\Backend\ProductsWishlist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Products\Models\Products;
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
        $post = new Products;

        return [
            'post_id' => [
                'required', 'integer',
                Rule::exists($post->getTable(), 'id')->where(function ($query) use ($post) {
                    $query->where('type', $post->type);
                })
            ],
            'user_id' => [
                'required', 'integer',
                Rule::exists((new Users)->getTable(), 'id')
            ]
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
