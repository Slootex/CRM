<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_has_permission extends Model
{
    use HasFactory;

    public $primaryKey = "id";

    public function role() {
        return $this->belongsTo(role::class, "id", "role_id");
    }

    public function permission() {
        return $this->hasMany(permission::class, "id", "permission_id");
    }
}
