<?php

namespace app\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use app\Models\seals;


class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function status()
    {
        return $this->belongsTo('App\UserStatus');
    }

    public function seals()
    {
        return $this->belongsTo(seals::class, "used_by", "id");
    }

    public function activeOrdersPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "employee", "id");
    }
}
