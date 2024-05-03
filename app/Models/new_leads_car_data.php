<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class new_leads_car_data extends Model
{
    use HasFactory;

    protected $primaryKey = 'process_id';

    public function newLeadsPersonData()
    {
        return $this->hasOne(new_leads_person_data::class, 'process_id');
    }
}
