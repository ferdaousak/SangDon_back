<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Typesang extends Model
{
    use HasFactory,Notifiable;


    protected $table = 'type_sangs';

    protected $fillable = [
        'tsang',
    ];

    //l'utilisateur qui a effectué le don
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //type de sang du don
    public function dons()
    {
        return $this->hasMany(Don::class);
    }
}
