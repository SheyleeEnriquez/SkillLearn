<?php

namespace App\Http\Livewire\Usuarios\Permiso;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permiso extends Component
{
    public $permisos, $id_permiso, $nombre, $id_delete;

    public function mount()
    {
        $this->refreshPermissions();
    }

    public function render()
    {
        return view('livewire.usuarios.permiso.view');
    }

    // LIMPIAR LOS CAMPOS AL CANCELAR O CERRAR FORMULARIO
    public function cancel()
    {
        $this->resetInput();
    }

    // LIMPIAR LOS CAMPOS
    public function resetInput()
    {
        $this->id_permiso = '';
    }

    public function refreshPermissions()
    {
        $this->permisos = Permission::all();
    }

    // Crear nuevo permiso
    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $this->nombre
        ]);

        $this->resetInput();
        session()->flash('message', 'Permiso creado con éxito.');
        $this->refreshPermissions();
        $this->dispatchBrowserEvent('close-modal');
    }

    // Editar permiso
    public function edit($id)
    {
        $permiso = Permission::findOrFail($id);
        $this->id_permiso = $permiso->id;
        $this->nombre = $permiso->name;
    }

    // Actualizar permiso
    public function update()
    {
        $this->validate([
            'nombre' => 'required|string|unique:permissions,name,' . $this->id_permiso,
        ]);

        $permiso = Permission::findOrFail($this->id_permiso);
        $permiso->update([
            'name' => $this->nombre,
        ]);

        $this->resetInput();
        session()->flash('message', 'Permiso actualizado con éxito.');
        $this->refreshPermissions();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function delete_confirmation($id)
    {
        $this->id_delete = $id;
    }

    // Eliminar permiso
    public function delete()
    {
        $permiso = Permission::findOrFail($this->id_delete);
        $permiso->delete();
        session()->flash('message', 'Permiso eliminado con éxito.');
        $this->refreshPermissions();
        $this->dispatchBrowserEvent('close-modal');
    }
}
