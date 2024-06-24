<?php

namespace App\Models;

use App\Traits\GoogleAnalytics;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoogleAnalyticsUrl extends Model
{
    use HasFactory, SerializeDate, GoogleAnalytics;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'path',
        'title',
        'visitors',
        'pageviews'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime'
    ];

    /**
     * Scope a query return total data.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTotalData(Builder $query)
    {
        return $query->select([
            'path',
            'title',
            DB::raw('SUM(visitors) as visitors'),
            DB::raw('SUM(pageviews) as pageviews')
        ])->groupBy([
            'path',
            'title'
        ]);
    }
}
