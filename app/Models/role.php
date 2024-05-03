<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class role extends Model
{
    use HasFactory;
    use HasRoles;

    protected $fillable = ['name'];    
    public function roleid() {
        return $this->hasMany(role_has_permission::class, "role_id", "id");
    }
    

}
