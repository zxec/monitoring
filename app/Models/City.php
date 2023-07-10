<?php

namespace App\Models;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region_id',
    ];

    /**
     * An position is owned by region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
