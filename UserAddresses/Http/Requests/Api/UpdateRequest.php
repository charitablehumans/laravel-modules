<?php

namespace Modules\UserAddresses\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Geocodes\Models\Geocodes;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $input = $this->input();

        return [
            'name' => ['required', 'between:0,191'],
            'phone_number' => ['required', 'between:0,20'],
            'province_id' => [
                'required', 'integer', 'digits_between:1,20',
                Rule::exists((new Geocodes)->getTable(), 'id')->where(function ($query) {
                    $query->where('type', 'province');
                }),
            ],
            'regency_id' => [
                'required', 'integer', 'digits_between:1,20',
                Rule::exists((new Geocodes)->getTable(), 'id')->where(function ($query) use ($input) {
                    $query->where('type', 'regency')->where('parent_id', $input['province_id']);
                }),
            ],
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
