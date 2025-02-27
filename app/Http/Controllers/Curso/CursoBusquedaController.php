<?php

namespace App\Http\Controllers\Curso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CursoBusquedaController extends Controller
{
    public function index(){
        return view('livewire.cursos.busqueda.index');
    }
}
