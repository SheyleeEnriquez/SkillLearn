<?php

namespace App\Http\Controllers\Curso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InscritoController extends Controller
{
    public function index(){
        return view('livewire.cursos.inscrito.index');
    }
}
