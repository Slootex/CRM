<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_workflow extends Model
{
    use HasFactory;

    public function activeOrdersPersonData() {
        return $this->belongsTo(active_orders_person_data::class, 'process_id', 'process_id');
    }

    public function workflowAddon() {
        return $this->hasOne(workflow_addon::class, 'workflowid', 'id');
    }
}
