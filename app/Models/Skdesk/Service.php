<?php

namespace App\Models\Skdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql_SkDesk';
}
