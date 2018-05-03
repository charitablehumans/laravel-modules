<?php

namespace Modules\Transactions\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\TransactionDetails\Models\TransactionDetails;
use Modules\Transactions\Models\Transactions;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(\Modules\Transactions\Http\Requests\Api\StoreRequest $request)
    {
        // 1. Transaction
        return \DB::transaction(function () use ($request) {
            $errors = false;

            // 2. Insert transactions
            $transaction = new Transactions;
            $transaction->fill($request->input());
            $transaction->receiver_id = \Auth::user()->id;
            $transaction->due_date = \Carbon\Carbon::now()->addDay();
            $transaction->save();

            // 3. Validate all input
                // 3.1 transaction_details
                    foreach ($request->input('transaction_details') as $i => $transactionDetail) {

                        // 3.1.1. Validate
                        $validator = \Validator::make($transactionDetail, [
                            'quantity' => [
                                'required', 'integer', 'digits_between:0,20',
                                new \Modules\Products\Rules\StockCheck($transactionDetail),
                            ],
                            'product_id' => [
                                'required', 'integer', 'digits_between:0,20',
                                Rule::exists('posts', 'id')->where(function ($query) {
                                    $query->where('type', 'product');
                                }),
                            ],
                        ]);

                        // 3.1.2 If fail / stock is not enough, set errors
                        if ($validator->fails()) {
                            $errors['transaction_details'][$i] = $validator->errors();
                        } else {
                            // 3.1.3 Select products
                            $product = \Modules\Products\Models\Products::findOrfail($transactionDetail['product_id']);

                            // 3.1.4 Create transaction_details
                            $transaction->transactionDetails()->saveMany([
                                new TransactionDetails([
                                    'quantity' => $transactionDetail['quantity'],
                                    'product_id' => $product->id,
                                    'product_sell_price' => $product->getPostProductSellPrice(),
                                    'product_weight' => $product->getPostProductWeight(),
                                ])
                            ]);

                            // 3.1.5 Reduce stock
                            $product->postProduct->stock -= $transactionDetail['quantity'];
                            $product->postProduct->save();
                        }
                    }

                // 3.2 transaction_shipment
                    // 3.2.1 Validate
                    $validator = \Validator::make(collect($request->input('transaction_shipment'))->toArray(), (new \Modules\TransactionShipment\Http\Requests\Api\StoreRequest)->rules());
                    if ($validator->fails()) { // 3.2.2 If fail, set errors
                        $errors['transaction_shipment'] = $validator->errors();
                    } else {
                        // 3.2.3 Create transactions_shipment
                        $transaction->transactionShipment()->save(
                            new \Modules\TransactionShipment\Models\TransactionShipment($request->input('transaction_shipment'))
                        );
                    }

                // 3.3 transaction_shipping_address
                    // 3.3.1 Validate
                    $validator = \Validator::make(collect($request->input('transaction_shipping_address'))->toArray(), (new \Modules\TransactionShippingAddress\Http\Requests\Api\StoreRequest)->rules());
                    if ($validator->fails()) { // 3.3.2 If fail, set errors
                        $errors['transaction_shipping_address'] = $validator->errors();
                    } else {
                        // 3.3.3 Select user_addresses
                        $userAddress = \Modules\UserAddresses\Models\UserAddresses::findOrfail($request->input('transaction_shipping_address.user_address_id'));

                        // 3.3.4 Create transaction_shipping_address
                        $transaction->transactionShippingAddress()->save(
                            new \Modules\TransactionShippingAddress\Models\TransactionShippingAddress($userAddress->getAttributes())
                        );
                    }

            // 4. If has errors, roll back, return 422
            if ($errors) {
                \DB::rollBack();
                return response()->json(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // 5. If has not errors, return 200
            if ($request->has('balance')) {
                // 5.1 Insert user_balance_histories, update users
                $user = \Auth::user();
                $user->balance -= $request->input('balance');
                $user->userBalanceHistoryCreate(['type' => 'transaction_pending', 'reference_id' => $transaction->id]);
                $user->save();
            }

            // 5.3 Update transactions
            $transaction->number = $transaction->id;
            $transaction->sync();
            $transaction->status = $transaction->grand_total > 0 ? 'pending' : 'new';
            $transaction->save();

            $transaction = Transactions::findOrfail($transaction->id);
            return response()->json(new \Modules\Transactions\Http\Resources\Api\TransactionResource($transaction));
        });
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        //
    }
}
