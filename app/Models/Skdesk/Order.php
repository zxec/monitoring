<?php

namespace App\Models\Skdesk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'mysql_SkDesk';

    const STATUS_COMPLETED = 3;
    const STATUS_POSTPONED = 10;

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'id_city');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Statusbid::class, 'id_status');
    }
}
