<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warenausgang_history extends Model
{
    use HasFactory;

    protected $table = 'warenausgang_history';

    protected $primaryKey = 'id';


    public function shelfe()
    {
        return $this->hasOne(used_shelfes::class, 'component_number', 'component_number');
    }
}
