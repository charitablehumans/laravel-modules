<?php

namespace Modules\Users\Rules;

use Modules\Users\Models\Users;
use Illuminate\Contracts\Validation\Rule;

class PhoneNumberVerificationCodeCheck implements Rule
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
        if (isset($this->attributes['phone_number'])) {
            if (Users::where('phone_number', $this->attributes['phone_number'])->where('verification_code', $value)->exists()) {
                return true;
            }
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
        return trans('validation.custom.users.verification_code_is_invalid');
    }
}
