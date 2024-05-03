<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class email_inbox_entwurf extends Model
{
    use HasFactory;
    protected $table = "email_inbox_entwurf";
    
    public function emailinbox()
    {
        return $this->hasOne(emailinbox::class, "email_id", "email_id");
    }
}
