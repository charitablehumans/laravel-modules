<?php

namespace Modules\DokuMyshortcart\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\DokuMyshortcart\Models\DokuMyshortcartPaymentMethods;
use Modules\Transactions\Models\Transactions;

class DokuMyshortcartTransactions extends Model
{
    protected $fillable = [
        // 'id',
        'transaction_id',
        'BASKET',
        'STOREID',
        'TRANSIDMERCHANT',

        'AMOUNT',
        'URL',
        'WORDS',
        'CNAME',
        'CEMAIL',

        'CWPHONE',
        'CHPHONE',
        'CMPHONE',
        'CCAPHONE',
        'CADDRESS',

        'CZIPCODE',
        'SADDRESS',
        'SZIPCODE',
        'SCITY',
        'SSTATE',

        'SCOUNTRY',
        'BIRTHDATE',
        'PAYMENTMETHODID',
    ];

    protected $table = 'doku_myshortcart_transactions';

    public function getPaymentMethodIdOptions()
    {
        return (new DokuMyshortcartPaymentMethods)->getPaymentMethodIdOptions();
    }

    public function transaction()
    {
        return $this->belongsTo('\Modules\Transactions\Models\Transactions', 'transaction_id');
    }

    public function transform($transactionId, $data)
    {
        $transaction = Transactions::findOrFail($transactionId);
        if (isset($data['PAYMENTMETHODID'])) {
            $paymentMethod = DokuMyshortcartPaymentMethods::select((new DokuMyshortcartPaymentMethods)->getTable().'.*')->search(['payment_method_id' => $data['PAYMENTMETHODID']])->firstOrFail();
            $transaction->payment_fee_formula = $paymentMethod->getPostmetaPaymentFeeFormula();
        } else {
            $transaction->payment_fee_formula = 0;
        }
        $transaction->sync()->save();

        $basket = '';
        if ($transaction->transactionDetails) {
            foreach ($transaction->transactionDetails as $transactionDetail) {
                $price = $transactionDetail->product_sell_price - $transactionDetail->product_discount;
                $basket .= $transactionDetail->product->title.','.$price.','.$transactionDetail->quantity.','.($price * $transactionDetail->quantity).';';
            }
        }
        if ($transactionShipment = $transaction->transactionShipment) {
            $weight = new \redzjovi\shipment\v1\delivery\Weight($transactionShipment->code);
            $totalWeight = $weight->roundUp($transaction->getTotalWeight() / 1000);
            $basket .= $transactionShipment->name.' '.$transactionShipment->service.','.$transactionShipment->cost.','.$totalWeight.','.($transactionShipment->cost * $totalWeight).';';
        }
        if ($transaction->payment_fee) {
            $basket .= trans('cms::cms.payment_fee').','.$transaction->payment_fee.',1,'.$transaction->payment_fee.';';
        }
        if ($transaction->balance) {
            $basket .= trans('cms::cms.balance').',-'.$transaction->balance.',1,-'.$transaction->balance.';';
        }

        $this->transaction_id = $transaction->id;
        $this->BASKET = $basket;
        $this->STOREID = \Config::get('dokumyshortcart.STORE_ID');
        $this->TRANSIDMERCHANT = time();

        $this->AMOUNT = $transaction->getGrandTotal();
        $this->URL = \URL::previous();
        $this->WORDS = sha1($this->AMOUNT.\Config::get('dokumyshortcart.SHARED_KEY').$this->TRANSIDMERCHANT);
        $this->CNAME = $transaction->transactionShippingAddress->name;
        $this->CEMAIL = $transaction->receiver->email;

        $this->CWPHONE = $transaction->transactionShippingAddress->phone_number;
        $this->CHPHONE = $transaction->transactionShippingAddress->phone_number;
        $this->CMPHONE = $transaction->transactionShippingAddress->phone_number;
        $this->CCAPHONE = '';
        $this->CADDRESS = '';

        $this->CZIPCODE = '';
        $this->SADDRESS = $transaction->transactionShippingAddress->address;
        $this->SZIPCODE = $transaction->transactionShippingAddress->postal_code;
        $this->SCITY = $transaction->transactionShippingAddress->regency->name;
        $this->SSTATE = $transaction->transactionShippingAddress->province->name;

        $this->SCOUNTRY = \Config::get('dokumyshortcart.SCOUNTRY');
        $this->BIRTHDATE = $transaction->receiver->date_of_birth;
        $this->PAYMENTMETHODID = isset($data['PAYMENTMETHODID']) ? $data['PAYMENTMETHODID'] : '';

        return $this;
    }
}
