<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workflow_addon extends Model
{
    use HasFactory;

    public function userWorkflow() {
        return $this->belongsTo(user_workflow::class, 'id', 'workflowid');
    }
}
