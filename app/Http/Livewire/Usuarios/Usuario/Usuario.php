<?php

namespace App\Http\Livewire\Usuarios\Usuario;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Usuario extends Component
{
    public $usuarios, $usuario_id, $rol, $nombre, $id_delete, $email, $contrasena, $repetir_contrasena;

    public function mount()
    {
        $this->usuarios = User::all();
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.usuarios.usuario.view', compact('roles'));
    }

    public function cancel()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->usuario_id = '';
        $this->nombre = '';
        $this->email = '';
        $this->contrasena = '';
        $this->repetir_contrasena = '';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'contrasena' => 'required|string|min:8|same:repetir_contrasena',
            'repetir_contrasena' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $this->nombre,
            'email' => $this->email,
            'password' => bcrypt($this->contrasena),
        ]);

        if ($this->rol) {
            $user->assignRole($this->rol);
        }

        $this->resetInput();
        session()->flash('message', 'Usuario creado con éxito.');
        $this->refreshUsers();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function usuarioRol($id)
    {
        $this->usuario_id = $id;
        $usuario = User::findOrFail($this->usuario_id);
        $this->nombre = $usuario->name;
        $rol = $usuario->roles()->first();
        $this->rol = $rol ? $rol->id : null;
    }

    public function cambiarRol()
    {
        $this->validate([
            'nombre' => 'nullable|string',
            'contrasena' => 'nullable|string|min:8|same:repetir_contrasena',
            'repetir_contrasena' => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($this->usuario_id);

        if ($this->rol) {
            if (Role::where('name', $this->rol)->exists()) {
                $user->syncRoles([$this->rol]);
            } else {
                session()->flash('message', 'El rol seleccionado no existe.');
                return;
            }
        }

        if ($this->contrasena) {
            $user->password = bcrypt($this->contrasena);
        }

        $user->save();

        session()->flash('message', 'Usuario actualizado con éxito.');
        $this->refreshUsers();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteConfirmation($id)
    {
        $this->id_delete = $id;
    }

    public function delete()
    {
        $user = User::findOrFail($this->id_delete);
        $user->delete();

        session()->flash('message', 'Usuario eliminado con éxito.');
        $this->refreshUsers();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function refreshUsers()
    {
        $this->usuarios = User::all();
    }
}
