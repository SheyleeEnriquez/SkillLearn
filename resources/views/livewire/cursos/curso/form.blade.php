<form>
    <div class="row">
        <div class="col-sm-5 mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control form-control" wire:model="nombre">
            @error('nombre')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
        <div class="col-sm-5 mb-3">
            <label class="form-label">Estado</label>
            <select class="form-select" wire:model="estado">
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-5 mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control form-control" wire:model="precio">
            @error('precio')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
        <div class="col-sm-9 mb-3">
            <label for="foto">Selecciona una imagen:</label>
            <input type="file" id="foto" class="form-control-file" wire:model="foto" accept="image/*">
            @if (is_string($foto))
                <img src="{{ asset('storage/' . $foto) }}" class="mt-2" style="max-width: 200px;"
                    alt="Imagen almacenada">
            @elseif ($foto)
                <img src="{{ $foto->temporaryUrl() }}" class="mt-2" style="max-width: 200px;" alt="Imagen cargada">
            @endif
            @error('foto')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
        <div class="col-sm-9 mb-3">
            <label class="form-label">Descripción</label>
            <textarea type="text" class="form-control form-control" wire:model="descripcion"> </textarea>
            @error('descripcion')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
    </div>
</form>
