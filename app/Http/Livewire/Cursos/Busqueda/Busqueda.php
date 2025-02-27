<?php

namespace App\Http\Livewire\Cursos\Busqueda;

use App\Models\Curso;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Busqueda extends Component
{
    public $buscador;

    public function render()
    {
        $cursos = Curso::when($this->buscador, function ($query) {
            $query->where('nombre', 'like', '%' . $this->buscador . '%')
                ->orWhere('descripcion', 'like', '%' . $this->buscador . '%')
                ->orWhere('precio', 'like', '%' . $this->buscador . '%');
        })->whereIn('estado_id', [2, 3])->get();
        return view('livewire.cursos.busqueda.view', compact('cursos'));
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        Suscripcion::create([
            'user_id' => Auth::id(),
            'curso_id' => $curso->id,
            'fecha_inicio' => Carbon::now()->toDateString(),
        ]);
        session()->flash('message', 'Inscripción realizada con éxito.');
    }
}
