<?php

namespace App\Models;

use App\Traits\GoogleAnalytics;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoogleAnalyticsOperatingSystem extends Model
{
    use HasFactory, SerializeDate, GoogleAnalytics;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'name',
        'version',
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
            'name',
            'version',
            DB::raw('SUM(visitors) as visitors'),
            DB::raw('SUM(pageviews) as pageviews')
        ])->groupBy([
            'name',
            'version'
        ]);
    }
}
