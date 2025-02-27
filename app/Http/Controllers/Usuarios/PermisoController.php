<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index(){
        return view('livewire.usuarios.permiso.index');
    }
}
