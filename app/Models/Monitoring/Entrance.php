<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrance extends Model
{
    use HasFactory;

    protected $fillable =[
        'monitoring_id',
        'number',
        'floor',
        'sticker',
        'competitor'
    ];


    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class);
    }
}
