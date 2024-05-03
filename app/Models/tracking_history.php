<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tracking_history extends Model
{
    use HasFactory;

    protected $table = 'tracking_history';

    protected $primaryKey = 'process_id';
}
