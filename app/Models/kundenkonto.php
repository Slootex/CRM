<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kundenkonto extends Model
{
    use HasFactory;

    protected $primaryKey   = "id";
    protected $table        = "kundenkonten";

    public function rechnungen() {
        return $this->hasMany(rechnungen::class, "process_id", "process_id");
    }

    public function active_orders_person_datas() {
        return $this->hasOne(active_orders_person_data::class, "process_id", "process_id");
    }

    public function new_leads_person_datas() {
        return $this->hasOne(new_leads_person_data::class, "process_id", "process_id");
    }

    public function merged_person_datas() {
        return $this->active_orders_person_datas()->union($this->new_leads_person_datas());
    }

}
