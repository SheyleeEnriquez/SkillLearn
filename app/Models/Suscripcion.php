<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','curso_id', 'fecha_inicio', 'fecha_fin'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curso(){
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
