<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emails_history extends Model
{
    use HasFactory;

    protected $table = 'emails_history';

    protected $primaryKey = 'id';
}
