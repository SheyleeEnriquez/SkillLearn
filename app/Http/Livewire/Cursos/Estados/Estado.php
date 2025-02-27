<?php

namespace App\Http\Livewire\Cursos\Estados;

use App\Models\Estado as ModelsEstado;
use Livewire\Component;

class Estado extends Component
{
    public $nombre, $id_estado, $id_delete;

    protected $rules = [
        'nombre' => 'required',
    ];

    public function render()
    {
        $estados = ModelsEstado::all();
        return view('livewire.cursos.estados.view', compact('estados'));
    }

    // LIMPIAR LOS CAMPOS AL CANCELAR O CERRAR FORMULARIO
    public function cancel()
    {
        $this->resetInput();
    }

    // LIMPIAR LOS CAMPOS
    public function resetInput()
    {
        $this->id_estado = '';
        $this->id_delete = '';
        $this->nombre = '';
    }

    // Crear nuevo permiso
    public function store()
    {
        $this->validate();
        ModelsEstado::create([
            'nombre' => $this->nombre,
        ]);

        $this->resetInput();
        session()->flash('message', 'Estado creado con éxito.');
        $this->dispatchBrowserEvent('close-modal');
    }

    // Editar permiso
    public function edit($id)
    {
        $estado = ModelsEstado::findOrFail($id);
        $this->id_estado = $estado->id;
        $this->nombre = $estado->nombre;
    }

    // Actualizar permiso
    public function update()
    {
        $this->validate();

        $estado = ModelsEstado::findOrFail($this->id_estado);

        $estado->update([
            'nombre' => $this->nombre,
        ]);

        $this->resetInput();
        session()->flash('message', 'Estado actualizado con éxito.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function delete_confirmation($id)
    {
        $this->id_delete = $id;
    }

    // Eliminar permiso
    public function delete()
    {
        $estado = ModelsEstado::findOrFail($this->id_delete);
        $estado->delete();
        $this->resetInput();
        session()->flash('message', 'Estado eliminado con éxito.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
