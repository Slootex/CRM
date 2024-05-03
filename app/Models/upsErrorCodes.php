<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class upsErrorCodes extends Model
{
    use HasFactory;

    protected $table = 'ups_error_codes';

    protected $priamryKey = 'code';
}
