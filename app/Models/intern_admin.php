<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intern_admin extends Model
{
    use HasFactory;

    protected $table = 'intern_admin';

    protected $primaryKey = 'process_id';
}
