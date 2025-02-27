<?php

namespace App\Http\Livewire\Cursos\Suscripcion;

use App\Models\Suscripcion as ModelsSuscripcion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Suscripcion extends Component
{
    public $fecha_inicio, $fecha_fin, $id_delete, $id_suscripcion;

    protected $rules = [
        'fecha_inicio' => 'required',
        'fecha_fin' => 'required',
    ];
    public function render()
    {
        $suscripciones = ModelsSuscripcion::all();
        return view('livewire.cursos.suscripcion.view', compact('suscripciones'));
    }

    // LIMPIAR LOS CAMPOS AL CANCELAR O CERRAR FORMULARIO
    public function cancel()
    {
        $this->resetInput();
    }

    // LIMPIAR LOS CAMPOS
    public function resetInput()
    {
        $this->fecha_inicio = '';
        $this->id_delete = '';
        $this->fecha_fin = '';
    }

    // Editar permiso
    public function edit($id)
    {
        $suscripcion = ModelsSuscripcion::findOrFail($id);
        $this->fecha_inicio = $suscripcion->fecha_inicio;
        $this->fecha_fin = $suscripcion->fecha_fin;
    }

    // Actualizar permiso
    public function update()
    {
        $this->validate();

        $suscripcion = ModelsSuscripcion::findOrFail($this->id_suscripcion);
        $suscripcion->update([
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);
        $this->resetInput();
        return redirect()->route('suscripciones.index')->with('message', 'Suscripcion actualizada con éxito.');
    }

    public function delete_confirmation($id)
    {
        $this->id_delete = $id;
    }

    // Eliminar permiso
    public function delete()
    {
        $curso = ModelsSuscripcion::findOrFail($this->id_delete);
        $curso->delete();
        $this->resetInput();
        session()->flash('message', 'Suscripcion eliminada con éxito.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
