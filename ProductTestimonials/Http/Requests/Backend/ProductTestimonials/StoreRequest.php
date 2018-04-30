<?php

namespace Modules\ProductTestimonials\Http\Requests\Backend\ProductTestimonials;

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
            'author_id' => [
                'required', 'integer',
                Rule::exists((new Users)->getTable(), 'id'),
            ],
            'content' => ['required'],
            'rating' => ['required', 'integer'],
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
