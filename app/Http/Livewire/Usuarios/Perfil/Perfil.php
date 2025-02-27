<?php

namespace App\Http\Livewire\Usuarios\Perfil;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Perfil extends Component
{
    public $nombre, $contrasena_anterior, $contrasena, $repetir_contrasena;

    public function mount()
    {
        $user = Auth::user();
        $this->nombre = $user->name;
    }

    public function updateProfile()
    {
        $this->validate([
            'nombre' => 'required|string|unique:users,name,' . Auth::id(),
            'contrasena_anterior' => 'nullable|string|min:8',
            'contrasena' => 'nullable|string|min:8|same:repetir_contrasena',
            'repetir_contrasena' => 'nullable|string|min:8',
        ]);

        $user = Auth::id();
        $user = User::findOrFail($user);
        $user->name = $this->nombre;

        if (!empty($this->contrasena_anterior) && !empty($this->contrasena)) {
            if (Hash::check($this->contrasena_anterior, $user->password)) {
                $user->password = Hash::make($this->contrasena);
            } else {
                session()->flash('error', 'La contraseña anterior no es correcta.');
                return;
            }
        }

        $user->save();

        return redirect()->route('home')->with('message', 'Perfil actualizado con éxito.');
    }

    public function render()
    {
        return view('livewire.usuarios.perfil.view');
    }
}
