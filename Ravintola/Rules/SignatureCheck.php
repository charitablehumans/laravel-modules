<?php

namespace Modules\Ravintola\Rules;

use Illuminate\Contracts\Validation\Rule;

class SignatureCheck implements Rule
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
        $signature = '';
        $signature .= \Config::get('ravintola.SECRET_KEY');
        $signature .= isset($this->attributes['pos_id']) ? $this->attributes['pos_id'] : '';
        $signature .= isset($this->attributes['outlet_code']) ? $this->attributes['outlet_code'] : '';
        $signature .= isset($this->attributes['verification_number']) ? $this->attributes['verification_number'] : '';
        $signature .= isset($this->attributes['phone_number']) ? $this->attributes['phone_number'] : '';
        $signature .= isset($this->attributes['transaction_amount']) ? $this->attributes['transaction_amount'] : '';
        $signature .= isset($this->attributes['transaction_deductible']) ? $this->attributes['transaction_deductible'] : '';

        if (hash('sha256', $signature) != $value) {
            return false;
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
        return 'Signature is invalid.';
    }
}
