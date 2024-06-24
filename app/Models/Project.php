<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes, SerializeDate;

    const BASE_IMAGE_PATH = '/images/base-image.png';
    const IMAGE_PATH = '/images/projects/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order',
        'name',
        'slug',
        'url',
        'image',
        'short_description',
        'description'
    ];

    /**
     * Scope a query return projects created between start and end dates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $startDate
     * @param  string  $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedBetween(Builder $query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay()->format('Y-m-d H:i:s'),
            Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s')
        ]);
    }

    public function getImagePathAttribute()
    {
        if ($this->image) {
            return self::IMAGE_PATH . $this->image;
        }
    }

    public function getImagePathWithTimestampAttribute()
    {
        if ($this->imagePath) {
            return $this->imagePath . '?' . strtotime($this->updated_at);
        }
    }
}
