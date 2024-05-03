<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inshipping extends Model
{
    use HasFactory;

    protected $table = 'inshipping';

    protected $primaryKey = 'process_id';
}
