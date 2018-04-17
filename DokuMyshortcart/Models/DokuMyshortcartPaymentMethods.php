<?php

namespace Modules\DokuMyshortcart\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Postmetas\Models\Postmetas;

class DokuMyshortcartPaymentMethods extends \Modules\Posts\Models\Posts
{
    protected $attributes = ['type' => 'doku_myshortcart_payment_method'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'doku_myshortcart_payment_method'); });
    }

    public function getPaymentMethodIdOptions()
    {
        $paymentMethodIdOptions = [];

        if ($paymentMethodIds = self::search(['status' => 'publish', 'sort' => 'title:asc'])->get()) {
            foreach ($paymentMethodIds as $paymentMethodId) {
                $paymentMethodIdOptions[$paymentMethodId->getPostmetaPaymentMethodId()] = $paymentMethodId->title;
            }
        }

        return $paymentMethodIdOptions;
    }

    public function getPostmetaPaymentFeeFormula()
    {
        $paymentFeeFormula = '';
        $paymentFeeFormula = isset($this->postmetas->where('key', 'payment_fee_formula')->first()->value) ? $this->postmetas->where('key', 'payment_fee_formula')->first()->value : $paymentFeeFormula;
        $paymentFeeFormula = is_array(request()->old('postmetas.payment_fee_formula')) ? request()->old('postmetas.payment_fee_formula') : $paymentFeeFormula;
        return $paymentFeeFormula;
    }

    public function getPostmetaPaymentMethodId()
    {
        $paymentMethodId = '';
        $paymentMethodId = isset($this->postmetas->where('key', 'PAYMENTMETHODID')->first()->value) ? $this->postmetas->where('key', 'PAYMENTMETHODID')->first()->value : $paymentMethodId;
        $paymentMethodId = is_array(request()->old('postmetas.PAYMENTMETHODID')) ? request()->old('postmetas.PAYMENTMETHODID') : $paymentMethodId;
        return $paymentMethodId;
    }

    public function scopeSearch($query, $params)
    {
        $query = parent::scopeSearch($query, $params);

        // postmetas
        isset($params['payment_method_id']) ? $query->join((new Postmetas)->getTable().' AS postmetas_payment_method_id', 'postmetas_payment_method_id.post_id', '=', self::getTable().'.id')->where('postmetas_payment_method_id.key', 'PAYMENTMETHODID')->where('postmetas_payment_method_id.value', $params['payment_method_id']) : '';
        isset($params['payment_method_id_like']) ? $query->join((new Postmetas)->getTable().' AS postmetas_payment_method_id_like', 'postmetas_payment_method_id_like.post_id', '=', self::getTable().'.id')->where('postmetas_payment_method_id_like.key', 'PAYMENTMETHODID')->where('postmetas_payment_method_id_like.value', 'LIKE', '%'.$params['payment_method_id_like'].'%') : '';
        isset($params['payment_fee_formula_like']) ? $query->join((new Postmetas)->getTable().' AS postmetas_payment_fee_formula', 'postmetas_payment_fee_formula.post_id', '=', self::getTable().'.id')->where('postmetas_payment_fee_formula.key', 'payment_fee_formula')->where('postmetas_payment_fee_formula.value', 'LIKE', '%'.$params['payment_fee_formula_like'].'%') : '';

        return $query;
    }
}
