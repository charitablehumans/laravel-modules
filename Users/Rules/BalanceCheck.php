<?php

namespace Modules\Users\Rules;

use Illuminate\Contracts\Validation\Rule;

class BalanceCheck implements Rule
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
        $user = \Modules\Users\Models\Users::where('id', $this->attributes['id'])->firstOrFail();

        if ($user->balance >= $value) {
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
        return trans('validation.custom.users.balance_is_not_enough');
    }
}
