<?php

namespace App\Models\Skdesk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusbid extends Model
{
    use HasFactory;
    
    protected $table = 'statusbid';
    protected $connection = 'mysql_SkDesk';
}
