<?php

namespace Modules\Ravintola\Http\Controllers\Api\v1\Voucher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ravintola\Models\RavintolaUserVouchers;

class QueryVoucherController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validator = \Validator::make($request->input(), [
            'pos_id' => ['required', 'between:0,20'],
            'outlet_code' => ['required', 'between:0,10'],
            'verification_number' => [
                'required', 'between:0,12',
                new \Modules\Users\Rules\PhoneNumberVerificationCodeCheck(['phone_number' => $request->input('phone_number')]),
            ],
            'phone_number' => ['required', 'between:0,20', 'exists:users,phone_number'],
            'signature' => [
                'required', 'between:0,64',
                new \Modules\Ravintola\Rules\SignatureCheck($request->input()),
            ],
        ]);

        // 2. If validation false
        if ($validator->fails()) {
            return response()->json(
                [
                    'response_status' => 'error',
                    'code' => 422,
                    'msg' => $validator->errors()->first(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // 3. Select user
        $user = \Modules\Users\Models\Users::where(['phone_number' => $request->input('phone_number'), 'verification_code' => $request->input('verification_number')])->firstOrFail();

        // 4. Update ravintola_user_vouchers set expired
        if ($ravintolaUserVouchers = RavintolaUserVouchers::where('user_id', $user->id)->where('status', 'new')->get()) {
            foreach ($ravintolaUserVouchers as $ravintolaUserVoucher) {
                $ravintolaUserVoucher->status = 'expired';
                $ravintolaUserVoucher->save();
            }
        }

        // 5. Insert ravintola_user_vouchers
        $ravintolaUserVoucher = new RavintolaUserVouchers;
        $ravintolaUserVoucher->fill($request->input());
        $ravintolaUserVoucher->fill([
            'user_id' => $user->id,
            'uuid' => \Ramsey\Uuid\Uuid::uuid1(),
            'expiry' => \Carbon\Carbon::now()->addDay()->toDateString(),
            'value' => $user->balance >= $ravintolaUserVoucher->getValueMaxOption() ? $ravintolaUserVoucher->getValueMaxOption() : $user->balance,
            'data' => json_encode($request->input()),
        ]);
        $ravintolaUserVoucher->save();

        // 6. Response json ok
        return response()->json([
            'status' => 'ok',
            'voucher' => new \Modules\Ravintola\Http\Resources\Api\v1\VoucherResource($ravintolaUserVoucher),
        ]);
    }
}
