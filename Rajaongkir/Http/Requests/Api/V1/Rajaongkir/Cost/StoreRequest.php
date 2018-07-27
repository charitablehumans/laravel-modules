<?php

namespace Modules\Rajaongkir\Http\Requests\Api\V1\Rajaongkir\Cost;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Geocodes\Models\Geocodes;

class StoreRequest extends FormRequest
{
    protected $geocode;

    public function __construct()
    {
        $this->geocode = new Geocodes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'origin' => [
                'required', 'integer',
                Rule::exists($this->geocode->getTable(), 'rajaongkir_id')->where(function ($query) {
                    $query->where('type', 'regency');
                }),
            ],
            'destination' => [
                'required', 'integer',
                Rule::exists($this->geocode->getTable(), 'rajaongkir_id')->where(function ($query) {
                    $query->where('type', 'regency');
                }),
            ],
            'weight' => ['required', 'integer'],
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
