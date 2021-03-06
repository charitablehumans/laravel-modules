<?php

namespace Modules\Transactions\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\Users;

class Transactions extends Model
{
    protected $attributes = [
        'status' => 'pending',
    ];

    protected $fillable = [
        // 'id',
        'type', // { purchase, sales }
        'sender_id',
        'receiver_id',
        'number',

        'status', // { pending, new, processed, sent, received, finished }
        'receipt_number',
        'due_date',
        'payment',
        'payment_date',

        'payment_fee_formula',
        'payment_status',
        'payment_type',
        'total_sell_price',
        'total_discount',

        'total_weight',
        'total_shipping_cost', // round(total_weight) * transactions_shipments.cost * transactions_shipments.distance
        'payment_fee',
        'balance',
        'grand_total', // total_price - total_discount + total_shipping_cost + payment_fee - balance

        'notes',
    ];

    protected $table = 'transactions';

    public static $paymentStatusFalse = '0';
    public static $paymentStatusTrue = '1';
    public static $statusNew = 'new';
    public static $statusPending = 'pending';
    public static $statusReceived = 'received';
    public static $statusSent = 'sent';

    public function getGrandTotal()
    {
        $grandTotal = 0;
        $grandTotal = $this->getTotalSellPrice() - $this->getTotalDiscount() + $this->getTotalShippingCost() + $this->payment_fee - $this->balance;
        return $grandTotal;
    }

    public function getPaymentFee()
    {
        $grandTotal = $this->getTotalSellPrice() - $this->getTotalDiscount() + $this->getTotalShippingCost();
        $paymentFeeFormula = str_replace('total', $grandTotal, $this->payment_fee_formula);
        $paymentFee = eval('return '.$paymentFeeFormula.';');
        return $paymentFee;
    }

    public function getSender()
    {
        return \Cache::remember('users-'.$this->sender_id, 1440, function () {
            return $this->sender ? $this->sender : new Users;
        });
    }

    public function getSenderIdOptions()
    {
        return self::search(['sort' => 'sender_name:asc'])->get()->pluck('sender_name', 'sender_id')->toArray();
    }

    public function getStatusOptions()
    {
        $statusOptions['pending'] = trans('cms::cms.pending');
        $statusOptions['new'] = trans('cms::cms.new');
        $statusOptions['processed'] = trans('cms::cms.processed');
        $statusOptions['sent'] = trans('cms::cms.sent');
        \Config::get('cms.transactions.status_options.received') ? $statusOptions['received'] = trans('cms::cms.received') : '';
        \Config::get('cms.transactions.status_options.finished') ? $statusOptions['finished'] = trans('cms::cms.finished') : '';
        \Config::get('cms.transactions.status_options.returned') ? $statusOptions['returned'] = trans('cms::cms.returned') : '';
        return $statusOptions;
    }

    public function getStoreIdNameOptions()
    {
        return (new Users)->getStoreIdNameOptions();
    }

    public function getTotalDiscount()
    {
        $totalDiscount = 0;

        if ($this->transactionDetails) {
            foreach ($this->transactionDetails as $transactionDetail) {
                $totalDiscount += $transactionDetail->quantity * $transactionDetail->product_discount;
            }
        }

        return $totalDiscount;
    }

    public function getTotalSellPrice()
    {
        $totalSellPrice = 0;

        if ($this->transactionDetails) {
            foreach ($this->transactionDetails as $transactionDetail) {
                $totalSellPrice += $transactionDetail->quantity * $transactionDetail->product_sell_price;
            }
        }

        return $totalSellPrice;
    }

    public function getTotalShippingCost()
    {
        $totalShippingCost = 0;

        $weight = new \redzjovi\shipment\v1\delivery\Weight($this->transactionShipment->code);
        $totalWeight = $weight->roundUp($this->getTotalWeight() / 1000);

        $totalShippingCost = $totalWeight
            * $this->transactionShipment->distance
            * $this->transactionShipment->cost;

        return $totalShippingCost;
    }

    public function getTotalQuantity()
    {
        $totalQuantity = 0;

        if ($this->transactionDetails) {
            foreach ($this->transactionDetails as $transactionDetail) {
                $totalQuantity += $transactionDetail->quantity;
            }
        }

        return $totalQuantity;
    }

    public function getTotalWeight()
    {
        $totalWeight = 0;

        if ($this->transactionDetails) {
            foreach ($this->transactionDetails as $transactionDetail) {
                $totalWeight += $transactionDetail->quantity * $transactionDetail->product_weight;
            }
        }

        return $totalWeight;
    }

    public function process($id)
    {
        $transaction = self::search(['id' => $id, 'status' => 'new'])->firstOrFail();
        $transaction->status = 'processed';
        $transaction->save();

        // check shipment using Rpx
        if ($transaction->transactionShipment->code == 'rpx' && config('rpx.name')) {

            // send transaction data and get return awb from sendShipmentData
            $this->modelRpxSoap = new \Modules\Rpx\Models\RpxSoap;
            $awb = $this->modelRpxSoap->sendShipmentData($transaction);

            // update receipt_number column via Rpx model
            $this->modelTransactionsRpx = new \Modules\Rpx\Models\TransactionsRpx;
            $this->modelTransactionsRpx->processSendShipmentData($id, $awb);
        }
    }

    public function receiver()
    {
        return $this->belongsTo('\Modules\Users\Models\Users', 'receiver_id');
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn('id', $params['id_in']) : '';
        isset($params['type']) ? $query->where('type', $params['type']) : '';
        isset($params['sender_id']) ? $query->where('sender_id', $params['sender_id']) : '';
        if (isset($params['sender_store_id'])) {
            $query->whereHas('sender', function ($sender) use ($params) {
                $sender->where('store_id', $params['sender_store_id']);
            });
        }
        isset($params['number_like']) ? $query->where('number', 'like', '%'.$params['number_like'].'%') : '';
        if (isset($params['grand_total'])) {
            if (isset($params['grand_total_operator'])) {
                $query->where('grand_total', $params['grand_total_operator'], $params['grand_total']);
            } else {
                $query->where('grand_total', $params['grand_total']);
            }
        }

        isset($params['mime_type']) ? $query->where('mime_type', $params['mime_type']) : '';
        if (isset($params['mime_type_like_in'])) {
            $mimeTypeLikes = explode(',', $params['mime_type_like_in']);
            $query->where(function ($query) use ($mimeTypeLikes) {
                foreach ($mimeTypeLikes as $mimeTypeLike) {
                    $query->orWhere('mime_type', 'like', '%'.$mimeTypeLike.'%');
                }
            });
        }
        isset($params['status']) ? $query->where('status', $params['status']) : '';
        isset($params['created_at']) ? $query->where(self::getTable().'.created_at', 'like', '%'.$params['created_at'].'%') : '';
        isset($params['created_at_date']) ? $query->whereDate(self::getTable().'.created_at', '=', $params['created_at_date']) : '';
        isset($params['updated_at_date']) ? $query->whereDate(self::getTable().'.updated_at', '=', $params['updated_at_date']) : '';

        if (isset($params['purchase_ownership']) && $params['purchase_ownership'] === true) {
            if (\Auth::check() && \Auth::user()->can('backend transactions purchase all') === false) {
                $query->where('receiver_id', \Auth()->user()->id);
            }
        }
        if (isset($params['sales_ownership']) && $params['sales_ownership'] === true) {
            if (\Auth::check() && \Auth::user()->can('backend transactions sales all') === false) {
                $query->where('sender_id', \Auth()->user()->id);
            }
        }

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            if (in_array($sort[0], ['number', 'receipt_number', 'grand_total', 'created_at', 'updated_at'])) {
                $query->orderBy(self::getTable().'.'.$sort[0], $sort[1]);
            } else if (in_array($sort[0], ['sender_name'])) {
                $query->join((new Users)->getTable().' AS sender', function ($join) {
                    $join->on('sender.id', '=', self::getTable().'.sender_id');
                })
                ->orderBy($sort[0], $sort[1])
                ->select([
                    self::getTable().'.*',
                    'sender.name AS sender_name',
                ]);
            } else if (in_array($sort[0], ['sender_store_name'])) {
                $query->join((new Users)->getTable().' AS sender', function ($join) {
                    $join->on('sender.id', '=', self::getTable().'.sender_id');
                })
                ->join((new Users)->getTable().' AS sender_store', function ($join) {
                    $join->on('sender_store.id', '=', 'sender.store_id');
                })
                ->orderBy($sort[0], $sort[1])
                ->select([
                    self::getTable().'.*',
                    'sender_store.name AS sender_store_name',
                ]);
            } else {
                count($sort) == 2 ? $query->orderBy($sort[0], $sort[1]) : '';
            }
        }

        return $query;
    }

    public function send($id)
    {
        $transaction = self::where('id', $id)->whereIn('status', ['processed', 'sent'])->firstOrFail();
        $transaction->status = self::$statusSent;
        $transaction->save();
        return $transaction;
    }

    public function sender()
    {
        return $this->belongsTo('\Modules\Users\Models\Users', 'sender_id');
    }

    public function sync()
    {
        $this->total_sell_price = $this->getTotalSellPrice();
        $this->total_discount = $this->getTotalDiscount();
        $this->total_weight = $this->getTotalWeight();
        $this->total_shipping_cost = $this->getTotalShippingCost();
        $this->payment_fee = $this->getPaymentFee();
        $this->grand_total = $this->getGrandTotal();
        return $this;
    }

    public function transactionDetails()
    {
        return $this->hasMany('\Modules\TransactionDetails\Models\TransactionDetails', 'transaction_id');
    }

    public function transactionShipment()
    {
        return $this->hasOne('\Modules\TransactionShipment\Models\TransactionShipment', 'transaction_id');
    }

    public function transactionShippingAddress()
    {
        return $this->hasOne('\Modules\TransactionShippingAddress\Models\TransactionShippingAddress', 'transaction_id');
    }
}
