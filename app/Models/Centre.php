<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centre extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }
}
