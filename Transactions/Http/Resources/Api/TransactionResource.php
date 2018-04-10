<?php

namespace Modules\Transactions\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class TransactionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'type' => $this->type,
            'sender_id' => (int) $this->sender_id,
            'sender' => $this->sender,
            'receiver_id' => (int) $this->receiver_id,
            'receiver' => $this->receiver,
            'number' => $this->number,
            'status' => $this->status,
            'receipt_number' => $this->receipt_number,
            'due_date' => $this->due_date,
            'payment' => $this->payment,
            'payment_status' => $this->payment_status,
            'payment_date' => $this->payment_date,
            'total_sell_price' => (int) $this->total_sell_price,
            'total_discount' => (int) $this->total_discount,
            'total_weight' => (int) $this->total_weight,
            'total_shipping_cost' => (int) $this->total_shipping_cost,
            'grand_total' => (int) $this->grand_total,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'transaction_details' => \Modules\TransactionDetails\Http\Resources\Api\TransactionDetailResource::collection($this->transactionDetails),
            'transaction_shipment' => $this->transactionShipment,
            'transaction_shipping_address' => new \Modules\TransactionShippingAddress\Http\Resources\Api\TransactionShippingAddressResource($this->transactionShippingAddress),
        ];
    }
}
