<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','estado_id', 'nombre', 'descripcion', 'precio', 'foto'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }

}
