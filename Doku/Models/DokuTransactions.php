<?php

namespace Modules\Doku\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Transactions\Models\Transactions;

class DokuTransactions extends Model
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
    ];

    protected $table = 'doku_transactions';

    public function transaction()
    {
        return $this->belongsTo('\Modules\Transactions\Models\Transactions', 'transaction_id');
    }

    public function transform($transactionId)
    {
        $transaction = Transactions::findOrFail($transactionId);

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

        $this->transaction_id = $transaction->id;
        $this->BASKET = $basket;
        $this->STOREID = \Config::get('doku.STORE_ID');
        $this->TRANSIDMERCHANT = time();

        $this->AMOUNT = $transaction->getGrandTotal();
        $this->URL = \URL::previous();
        $this->WORDS = sha1($this->AMOUNT.\Config::get('doku.SHARED_KEY').$this->TRANSIDMERCHANT);
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

        $this->SCOUNTRY = \Config::get('doku.SCOUNTRY');
        $this->BIRTHDATE = $transaction->receiver->date_of_birth;

        return $this;
    }
}
