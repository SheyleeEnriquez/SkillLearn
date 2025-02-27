<?php

namespace App\Http\Livewire\Cursos\Curso;

use App\Models\Curso as ModelsCurso;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Curso extends Component
{
    use WithFileUploads;

    public $nombre, $precio, $descripcion, $estado, $foto, $id_curso, $id_delete;

    protected $rules = [
        'nombre' => 'required',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'required',
        'foto' => 'required|image|max:2048',
    ];

    public function mount(){
        $this->estado = 2;
    }

    public function render()
    {
        $user = Auth::user();
        if ($user->id = 1) {
            $cursos = ModelsCurso::all();
        } else {
            $cursos = ModelsCurso::where('user_id', $user->id)->get();
        }
        $estados = Estado::all();
        return view('livewire.cursos.curso.view', compact('cursos', 'estados'));
    }

    // LIMPIAR LOS CAMPOS AL CANCELAR O CERRAR FORMULARIO
    public function cancel()
    {
        $this->resetInput();
    }

    // LIMPIAR LOS CAMPOS
    public function resetInput()
    {
        $this->id_curso = '';
        $this->id_delete = '';
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio = '';
        $this->foto = '';
    }

    // Crear nuevo permiso
    public function store()
    {
        $this->validate();
        // Procesa la imagen cargada
        $nombreArchivo = str_replace(' ', '', $this->nombre) . '.' . $this->foto->extension();
        $rutaFoto = $this->foto->storeAs('public/fotos', $nombreArchivo);
        $rutaFoto = 'fotos/' . $nombreArchivo;

        $curso = ModelsCurso::create([
            'user_id' => Auth::id(),
            'estado_id' => $this->estado,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'foto' => $rutaFoto,
        ]);

        $this->resetInput();
        session()->flash('message', 'Curso creado con éxito.');
        $this->dispatchBrowserEvent('close-modal');
    }

    // Editar permiso
    public function edit($id)
    {
        $curso = ModelsCurso::findOrFail($id);
        $this->id_curso = $curso->id;
        $this->nombre = $curso->nombre;
        $this->estado = $curso->estado_id;
        $this->descripcion = $curso->descripcion;
        $this->precio = $curso->precio;
        $this->foto = $curso->foto;
    }

    // Actualizar permiso
    public function update()
    {
        $curso = ModelsCurso::findOrFail($this->id_curso);
        if ($this->foto && $this->foto != $curso->foto) {
            Storage::delete($curso->foto);
            $nombreArchivo = str_replace(' ', '', $this->nombre) . '.' . $this->foto->extension();
            $rutaFoto = $this->foto->storeAs('public/fotos', $nombreArchivo);
            $rutaFoto = 'fotos/' . $nombreArchivo;
            $curso->update([
                'estado_id' => $this->estado,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
                'foto' => $rutaFoto,
            ]);
        } else {
            $curso->update([
                'estado_id' => $this->estado,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
            ]);
        }
        $this->resetInput();
        return redirect()->route('cursos')->with('message', 'Curso actualizado con éxito.');
    }

    public function delete_confirmation($id)
    {
        $this->id_delete = $id;
    }

    // Eliminar permiso
    public function delete()
    {
        $curso = ModelsCurso::findOrFail($this->id_delete);
        $curso->delete();
        $this->resetInput();
        session()->flash('message', 'Curso eliminado con éxito.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
