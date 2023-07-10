<?php

namespace App\Models\Skdesk;

use App\Models\Skdesk\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apply extends Model
{
    use HasFactory;

    protected $connection = 'mysql_SkDesk';

    protected $table = 'apply';

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
