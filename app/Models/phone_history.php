<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phone_history extends Model
{
    use HasFactory;

    protected $table = 'phone_historys';

    public function new_leads_person_data() {
        return $this->hasOne(new_leads_person_data::class, "process_id", "process_id");
    }

    public function zuweisung() {
        return $this->hasMany(zuweisung::class, "textid", "textid");
    }
    
}
