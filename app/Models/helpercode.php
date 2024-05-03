<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class helpercode extends Model
{
    use HasFactory;

    protected $table = 'helpercode';

    protected $primaryKey = 'helper_code';
}
