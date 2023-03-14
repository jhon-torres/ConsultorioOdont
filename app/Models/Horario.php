<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    static $rules = [
        'horario' => 'required'
    ];

    protected $guarded = [];

    // RELACION DE UNO A MUCHO
    public function users () {
        return $this->belongsTo(Horario::class);
    }

    public function estadoCita (){
        return $this->belongsTo(EstadoCita::class);
    }
}
