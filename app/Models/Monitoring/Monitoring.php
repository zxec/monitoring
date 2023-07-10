<?php

namespace App\Models\Monitoring;

use Carbon\Carbon;
use App\Models\Skdesk\City;
use App\Models\Monitoring\Entrance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable =[
        'city_id',
        'order_id',
        'master_id',
        'city',
        'street',
        'house_number',
        'latitude',
        'longitude',
        'date'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function entrances(): HasMany
    {
        return $this->hasMany(Entrance::class);;
    }

    protected function dateFormat(): Attribute
    {
        return Attribute::make(
            get: fn ($date) => Carbon::parse($date)->format('d.m.y'),
        );
    }
}
