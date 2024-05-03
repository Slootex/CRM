<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    use HasFactory;

    protected $table = 'file';
    protected $primaryKey = 'id';

    
    public function file()
    {
        return $this->hasOne(emailinbox::class, "email_id", "component_id");
    }

    public function newLeadsPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }

    public function activeOrdersPersonData() {
        return $this->belongsTo(active_orders_person_data::class, "process_id", "process_id");
    }

    public function warenausgang() {
        return $this->belongsTo(warenausgang::class, "file_id", "warenausgang_id");
    }
}
