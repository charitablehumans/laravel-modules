<?php

namespace Modules\Geocodes\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['type'] = ['required', 'between:0,191'];
        $rules['code'] = ['between:0,191'];
        $rules['name'] = ['required', 'between:0,191'];
        $rules['postal_code'] = ['between:0,10'];
        config('cms.geocodes.latitude') ? $rules['latitude'] = ['numeric'] : '';
        config('cms.geocodes.longitude') ? $rules['longitude'] = ['numeric'] : '';
        $rules['parent_id'] = ['integer', 'exists:geocodes,id'];
        config('cms.geocodes.rajaongkir_id') ? $rules['rajaongkir_id'] = ['integer'] : '';

        return $rules;
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
