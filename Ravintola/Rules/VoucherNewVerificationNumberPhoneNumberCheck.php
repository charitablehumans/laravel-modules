<?php

namespace Modules\Ravintola\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Ravintola\Models\RavintolaUserVouchers;

class VoucherNewVerificationNumberPhoneNumberCheck implements Rule
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
        if (RavintolaUserVouchers
            ::where('verification_number', $this->attributes['verification_number'])
            ->where('phone_number', $this->attributes['phone_number'])
            ->where('status', 'new')
            ->exists()
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The voucher is not exist.';
    }
}
