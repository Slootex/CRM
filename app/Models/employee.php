<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $primaryKey = 'id';

    protected $guard_name = 'web';

    public function activeOrdersPersonData()
    {
        return $this->belongsTo(active_orders_person_data::class);
    }

    public function permission()
    {
        return $this->hasMany(permission::class, 'userid', 'id');
    }
}
