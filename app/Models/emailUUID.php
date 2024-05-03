<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emailUUID extends Model
{
    use HasFactory;

    protected $table = 'emailUUID';

    protected $primaryKey = 'created_at';
}
