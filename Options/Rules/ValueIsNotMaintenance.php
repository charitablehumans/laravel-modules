<?php

namespace Modules\Options\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValueIsNotMaintenance implements Rule
{
    protected $option;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($option)
    {
        $this->option = $option;
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
        if ($this->option->value == 'maintenance') {
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
        return trans('cms::cms.under_maintenance');
    }
}
