<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demande extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $with = array('centre', 'type_sang');

    public function centre()
    {
        return $this->belongsTo(Centre::class, "id_centre");
    }

    public function type_sang()
    {
        return $this->belongsTo(Typesang::class, "id_type_sang");
    }
}
