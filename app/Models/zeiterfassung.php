<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zeiterfassung extends Model
{
    use HasFactory;

    protected $table = 'zeiterfassung';

    protected $primaryKey = "main_id";
}
