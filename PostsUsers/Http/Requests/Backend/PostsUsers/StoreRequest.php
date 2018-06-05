<?php

namespace Modules\PostsUsers\Http\Requests\Backend\PostsUsers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Posts\Models\Posts;
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
        $post = new Posts;

        return [
            'post_id' => [
                'required', 'integer', 'digits_between:1,20',
                Rule::exists($post->getTable(), 'id')->where(function ($query) use ($post) {
                    $query->where('type', $post->type);
                })
            ],
            'user_id' => [
                'required', 'integer', 'digits_between:1,20',
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
