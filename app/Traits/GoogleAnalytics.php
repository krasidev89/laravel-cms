<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait GoogleAnalytics
{
    /**
     * Scope a query return summary by date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSummaryByDate(Builder $query)
    {
        return $query->select([
            'date AS categories',
            DB::raw('SUM(visitors) as visitors'),
            DB::raw('SUM(pageviews) as pageviews')
        ])->groupBy('date');
    }
}
