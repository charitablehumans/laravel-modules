<?php

namespace Modules\Products\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Products\Models\Products;

class StockCheck implements Rule
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
        $product = Products::where('id', $this->attributes['product_id'])->firstOrFail();

        if ($product->getPostProductStock() >= $value) {
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
        return trans('validation.custom.products.stock_is_not_enough');
    }
}
