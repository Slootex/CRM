<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emailinbox extends Model
{
    use HasFactory;
    protected $table = "emailinbox";

    public function file()
    {
        return $this->hasMany(file::class, "component_id", "email_id");
    }

    public function email_inbox_entwurf()
    {
        return $this->hasOne(email_inbox_entwurf::class, "email_id", "email_id");
    }
}
