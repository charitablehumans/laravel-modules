<?php

namespace Modules\Ipay88\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Ipay88\Models\Ipay88TransactionLogs;
use Modules\Transactions\Models\Transactions;

class Ipay88Transactions extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'ipay88_transactions';

    public function getCurrency()
    {
        $currency = $this->currency ? $this->currency : collect($this->getCurrencyCurrencyDescription())->keys()->first();
        return $currency;
    }

    public function getCurrencyCurrencyDescription()
    {
        return [
            'IDR' => 'Indonesia Rupiah',
            'US' => 'US Dollar',
        ];
    }

    public function getEpaymentEntryUrl()
    {
        $mode = config('ipay88.mode');

        switch ($mode) {
            case 'production':
                $epaymentEntryUrl = 'https://payment.ipay88.co.id/epayment/entry.asp';
                break;
            case 'sandbox':
                $epaymentEntryUrl = 'https://sandbox.ipay88.co.id/epayment/entry.asp';
                break;
            default:
                $epaymentEntryUrl = 'https://sandbox.ipay88.co.id/epayment/entry.asp';
        }

        return $epaymentEntryUrl;
    }

    public function getSignature()
    {
        $merchantKey = config('ipay88.merchant_key');
        $merchantCode = config('ipay88.merchant_code');

        $source = $merchantKey.$merchantCode.$this->RefNo.$this->Amount.$this->Currency;
        return base64_encode($this->hex2bin(sha1($source)));
    }

    public function getPaymentMethodIdNameOptions()
    {
        return [
            '1' => 'Credit Card (IDR)',
            '4' => 'Mandiri clickpay (IDR)',
            '6' => 'PayPal (USD)',
            '7' => 'XL Tunai (IDR)',
            '9' => 'BII VA (Virtual Account)',
            '10' => 'Kartuku',
            '11' => 'CIMBClicks',
            '13' => 'Mandiri e-Cash',
            '14' => 'IB Muamalat',
            '15' => 'T-Cash',
            '16' => 'Indosat Dompetku',
            '17' => 'Mandiri ATM Automatic',
            '22' => 'Pay4ME',
        ];
    }

    public function getTransactionPaymentStatusOptions()
    {
        return [
            Ipay88TransactionLogs::$statusFail => Transactions::$paymentStatusFalse,
            Ipay88TransactionLogs::$statusSuccess => Transactions::$paymentStatusTrue,
            Ipay88TransactionLogs::$statusPending => Transactions::$paymentStatusFalse,
        ];
    }

    public function hex2bin($hexSource)
    {
        $bin = '';

        for ($i = 0; $i < strlen($hexSource); $i = $i + 2) {
            $bin .= chr(hexdec(substr($hexSource, $i, 2)));
        }

        return $bin;
    }

    public function transaction()
    {
        return $this->belongsTo('\Modules\Transactions\Models\Transactions', 'transaction_id');
    }

    public function transform($transactionId, $data)
    {
        $transaction = Transactions::findOrFail($transactionId);

        $this->transaction_id = $transaction->id;
        $this->MerchantCode = config('ipay88.merchant_code');
        $this->PaymentId = isset($data['PaymentId']) ? $data['PaymentId'] : '';
        $this->RefNo = time();

        $this->Amount = $transaction->getGrandTotal().'00';
        $this->Currency = isset($data['Currency']) ? $data['Currency'] : $this->getCurrency();
        $this->ProdDesc = isset($data['ProdDesc']) ? $data['ProdDesc'] : '';
        $this->UserName = $transaction->receiver->name;
        $this->UserEmail = $transaction->receiver->email;

        $this->UserContact = $transaction->receiver->phone_number;
        $this->Remark = $transaction->notes;
        $this->Lang = isset($data['Lang']) ? $data['Lang'] : '';
        $this->Signature = $this->getSignature();
        $this->ResponseURL = route('ipay88.api.v1.ipay88.epayment.entry.response.store');

        $this->BackendURL = route('ipay88.api.v1.ipay88.epayment.entry.backend.store');

        return $this;
    }
}
