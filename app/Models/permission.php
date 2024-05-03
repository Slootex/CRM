<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $primaryKey = 'userid';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function employee()
    {
        return $this->belongsTo(active_orders_person_data::class, 'id', 'userid');
    }

    public function role_has_permission(){
        return $this->belongsTo(role_has_permission::class, "permission_id", "id");
    }
}
