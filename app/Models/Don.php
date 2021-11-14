<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Don extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'adresse',
    ];

    //l'utilisateur qui a effectué le don
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    //type de sang du don
    public function type_sang()
    {
        return $this->belongsTo(Typesang::class,'type_sang_id');
    }
}
