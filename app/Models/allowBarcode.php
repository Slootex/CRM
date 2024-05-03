<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class allowBarcode extends Model
{
    use HasFactory;

    protected $table = 'allowbarcodes';

    protected $primaryKey = 'setting';
}
