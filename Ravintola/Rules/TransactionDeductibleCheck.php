<?php

namespace Modules\Ravintola\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Ravintola\Models\RavintolaUserVouchers;
use Modules\Users\Models\Users;

class TransactionDeductibleCheck implements Rule
{
    protected $attributes;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Users::where('phone_number', $this->attributes['phone_number'])->where('verification_code', 'verification_number')->first();

        $ravintolaUserVoucher = RavintolaUserVouchers
            ::where('verification_number', $this->attributes['verification_number'])
            ->where('phone_number', $this->attributes['phone_number'])
            ->where('status', 'new')->first();

        if ($ravintolaUserVoucher) {
            if ($ravintolaUserVoucher->user->balance < $this->attributes['transaction_deductible']) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Balance is smaller than transaction deductible.';
    }
}
