<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faketime extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $table = "faketime";
}
