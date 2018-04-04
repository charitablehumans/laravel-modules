<?php

namespace Modules\Geocodes\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Geocodes\Models\Geocodes\Provinces;
use Modules\Geocodes\Models\Geocodes\Regencies;
use Modules\Rajaongkir\Models\Rajaongkir;
use redzjovi\php\ArrayHelper;

class Geocodes extends Model
{
    protected $fillable = [
        'type',
        'code',
        'name',
        'postal_code',
        'latitude',
        'longitude',
        'parent_id',
        'rajaongkir_id',
    ];

    protected $table = 'geocodes';

    public function parent()
    {
        return $this->belongsTo('\Modules\Geocodes\Models\Geocodes', 'parent_id');
    }

    public function getParentIdOptions()
    {
        $search = [];
        $parents = self::search(['sort' => 'name:asc'])->get()->toArray();
        $parents = ArrayHelper::copyKeyName($parents, 'parent_id', 'parent');
        $tree = ArrayHelper::buildTree($parents);
        $tree = ArrayHelper::printTree($tree);
        $options = collect($tree)->pluck('tree_name', 'id')->toArray();

        return $options;
    }

    public function getRajaongkirIdOptions()
    {
        return self::orderBy('rajaongkir_id')->get()->pluck('rajaongkir_id', 'rajaongkir_id')->toArray();
    }

    public function getTypeOptions()
    {
        return [
            'province' => trans('cms::cms.province'),
            'regency' => trans('cms::cms.regency'),
            'district' => trans('cms::cms.district'),
        ];
    }

    public function scopeAction($query, $params)
    {
        if ($params['action'] == 'delete' && isset($params['action_id'])) {
            if ($geocodes = self::whereIn('id', $params['action_id'])->get()) {
                $geocodes->each(function ($geocode) { $geocode->delete(); });
            }
            flash(trans('cms::cms.data_has_been_deleted').' ('.$geocodes->count().')')->success()->important();
        }
        return $query;
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn('id', $params['id_in']) : '';
        isset($params['type']) ? $query->where('type', $params['type']) : '';
        isset($params['code']) ? $query->where('code', $params['code']) : '';
        isset($params['code_like']) ? $query->where('code', 'like', '%'.$params['code_like'].'%') : '';
        isset($params['name']) ? $query->where('name', $params['name']) : '';
        isset($params['name_like']) ? $query->where('name', 'like', '%'.$params['name_like'].'%') : '';
        isset($params['postal_code']) ? $query->where('postal_code', $params['postal_code']) : '';
        isset($params['postal_code_like']) ? $query->where('postal_code', 'like', '%'.$params['postal_code_like'].'%') : '';
        isset($params['latitute']) ? $query->where('latitute', $params['latitute']) : '';
        isset($params['latitute_like']) ? $query->where('latitute', 'like', '%'.$params['latitute_like'].'%') : '';
        isset($params['longitude']) ? $query->where('longitude', $params['longitude']) : '';
        isset($params['longitude_like']) ? $query->where('longitude', 'like', '%'.$params['longitude_like'].'%') : '';
        isset($params['parent_id']) ? $query->where('parent_id', $params['parent_id']) : '';
        isset($params['rajaongkir_id']) ? $query->where('rajaongkir_id', $params['rajaongkir_id']) : '';

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            $query->orderBy(
                $sort[0],
                isset($sort[1]) ? $sort[1] : null
            );
        }

        return $query;
    }

    public function sync()
    {
        $count = 0;
        $rajaongkir = new Rajaongkir;

        foreach ($provinces = $rajaongkir->getProvinces() as $province) {
            $model = Provinces::firstOrNew([
                'rajaongkir_id' => $province['province_id'],
            ]);
            $model->fill([
                'name' => $province['province'],
            ]);
            $model->save();

            $count++;
        }

        foreach ($cities = $rajaongkir->getCities() as $city) {
            $province = Provinces::where('rajaongkir_id', $city['province_id'])->first();

            $model = Regencies::firstOrNew([
                'rajaongkir_id' => $city['city_id'],
            ]);
            $model->fill([
                'name' => $city['type'].' '.$city['city_name'],
                'postal_code' => $city['postal_code'],
                'parent_id' => $province->id,
            ]);
            $model->save();

            $count++;
        }

        return $count;
    }
}
