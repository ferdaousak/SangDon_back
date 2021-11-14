<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Rdv extends Model
{
    use HasFactory,Notifiable;

    public function don()
    {
        return $this->belongsTo(Don::class);
    }

    public function centre()
    {
        return $this->belongsTo(Centre::class);
    }

    public function demande()
    {
        return $this->belongsTo(demande::class);
    }
}
