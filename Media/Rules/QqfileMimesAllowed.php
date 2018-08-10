<?php

namespace Modules\Media\Rules;

use Illuminate\Contracts\Validation\Rule;

class QqfileMimesAllowed implements Rule
{
    protected $attributes;
    protected $extensionNotAllowed = ['mov'];

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
        $extension = $this->attributes[$attribute]->getClientOriginalExtension();

        if (in_array($extension, $this->extensionNotAllowed)) {
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
        return 'This mime is not allowed.';
    }
}
