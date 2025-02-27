<form>
    <div class="row">
        <div class="col-sm-12 mb-3">
            <label class="form-label">Roles<samp class="text-eliminar">*</samp></label>
            <select class="form-select form-select" wire:model="rol">
                <option value="">Seleccione una opción</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->name }}">
                        {{ $rol->name }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control form-control" wire:model="nombre">
            @error('nombre')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control form-control" wire:model="contrasena">
            @error('contrasena')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
        <div class="col-sm-6 mb-3">
            <label class="form-label">Repetir Contraseña</label>
            <input type="password" class="form-control form-control" wire:model="repetir_contrasena">
            @error('repetir_contrasena')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
    </div>
</form>
