<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ville extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function centres()
    {
        return $this->hasMany(Centre::class);
    }
}
