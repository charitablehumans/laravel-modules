<?php

namespace Modules\UsersGames\Rules;

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
        $signature .= config('usersgames.secret_key');
        $signature .= isset($this->attributes['id']) ? $this->attributes['id'] : '';
        $signature .= isset($this->attributes['balance']) ? $this->attributes['balance'] : '';

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
        return trans('cms::cms.signature_is_invalid').'.';
    }
}
