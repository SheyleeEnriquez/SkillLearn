<?php

namespace App\Http\Livewire\Usuarios\Rol;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Rol extends Component
{
    public $roles, $id_rol, $nombre, $permiso,  $id_delete, $permisos, $selectedPermissions = [];

    public function mount()
    {
        $this->refreshRoles();
        $this->permisos = Permission::all();
        $this->selectedPermissions = [];
    }

    public function render()
    {
        return view('livewire.usuarios.rol.view');
    }

    // LIMPIAR LOS CAMPOS AL CANCELAR O CERRAR FORMULARIO
    public function cancel()
    {
        $this->resetInput();
    }

    // LIMPIAR LOS CAMPOS
    public function resetInput()
    {
        $this->id_rol = '';
        $this->id_delete = '';
        $this->permiso = '';
    }

    public function refreshRoles()
    {
        $this->roles = Role::all();
    }

    // Crear nuevo rol
    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|unique:roles,name',
        ]);

        $rol = Role::create([
            'name' => $this->nombre
        ]);

        $permissionNames = Permission::whereIn('id', $this->selectedPermissions)
            ->pluck('name')->toArray();
        $rol->syncPermissions($permissionNames);

        $this->resetInput();
        session()->flash('message', 'Rol creado con éxito.');
        $this->refreshRoles();
        $this->dispatchBrowserEvent('close-modal');
    }

    // Editar rol
    public function edit($id)
    {
        $rol = Role::findOrFail($id);
        $this->id_rol = $rol->id;
        $this->nombre = $rol->name;
        $this->selectedPermissions = $rol->permissions->pluck('id')->toArray();
    }

    // Actualizar rol
    public function update()
    {
        $this->validate([
            'nombre' => 'required|string|unique:roles,name,' . $this->id_rol,
        ]);

        $rol = Role::findOrFail($this->id_rol);
        $rol->update([
            'name' => $this->nombre,
        ]);

        $permissionNames = Permission::whereIn('id', $this->selectedPermissions)
            ->pluck('name')->toArray();
        $rol->syncPermissions($permissionNames);

        $this->resetInput();
        session()->flash('message', 'Rol actualizado con éxito.');
        $this->refreshRoles();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function delete_confirmation($id)
    {
        $this->id_delete = $id;
    }

    // Eliminar rol
    public function delete()
    {
        $rol = Role::findOrFail($this->id_delete);
        $rol->delete();
        session()->flash('message', 'Rol eliminado con éxito.');
        $this->refreshRoles();
        $this->dispatchBrowserEvent('close-modal');
    }
}
