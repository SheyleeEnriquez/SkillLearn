<?php

namespace App\Http\Livewire\Cursos\Inscrito;

use App\Models\Curso;
use App\Models\Suscripcion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Inscrito extends Component
{
    public function render()
    {
        $suscripciones_ids = Suscripcion::where('user_id', auth()->id())->pluck('curso_id');
        $cursos = Curso::whereIn('id', $suscripciones_ids)->get();
        return view('livewire.cursos.inscrito.view', compact('cursos'));
    }
}
