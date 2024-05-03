<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warenausgang extends Model
{
    use HasFactory;

    protected $table = 'warenausgang';

    protected $primaryKey = 'id';

    public function shelfe()
    {
        return $this->hasOne(used_shelfes::class, 'component_number', 'component_number');
    }

    public function file() {
        return $this->hasMany(file::class, "warenausgang_id", "file_id");
    }

    public function activeOrderPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }
}
