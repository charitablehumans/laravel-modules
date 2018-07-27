<?php

namespace Modules\Rajaongkir\Http\Requests\Api\V1\Rajaongkir\Cost\Courier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Geocodes\Models\Geocodes;
use Modules\Rajaongkir\Models\Rajaongkir;

class StoreRequest extends FormRequest
{
    protected $geocode;
    protected $rajaongkir;

    public function __construct()
    {
        $this->geocode = new Geocodes;
        $this->rajaongkir = new Rajaongkir;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $couriers = $this->rajaongkir->getCouriersId();

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
            'courier' => [
                'required',
                Rule::in($couriers),
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
