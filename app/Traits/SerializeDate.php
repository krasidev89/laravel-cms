<?php

namespace App\Traits;

trait SerializeDate
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(implode(' ', config()->get(['app.date_format', 'app.time_format'])));
    }
}
