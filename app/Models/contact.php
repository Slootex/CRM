<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', "firstname", "lastname", "id"];
    protected $primaryKey = "id";
    protected $table = "contacts";
}
