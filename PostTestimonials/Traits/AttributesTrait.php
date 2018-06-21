<?php

namespace Modules\PostTestimonials\Traits;

trait AttributesTrait
{
    public function getRating()
    {
        $this->rating = $this->id ? $this->rating : max($this->getRatingOptions());
        return \Request::old('rating', $this->rating);
    }

    public function getRatingOptions()
    {
        return [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
        ];
    }

    public function getRatingOptionsMax()
    {
        return max($this->getRatingOptions());
    }
}
