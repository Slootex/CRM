<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zuweisung extends Model
{
    use HasFactory;

    protected $table = 'zuweisungen';

    public function newLeadsPersonData()
    {
        return $this->belongsTo(new_leads_person_data::class, 'process_id', 'process_id');
    }

    public function activeOrdersPersonData()
    {
        return $this->belongsTo(new_leads_person_data::class, 'process_id', 'process_id');
    }

    public function phoneHistory()
    {
        return $this->belongsTo(phone_history::class, 'textid', 'textid');
    }
}
