<form>
    <div class="row">
        <div class="col-sm-12 mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control form-control" wire:model="nombre">
            @error('nombre')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
    </div>
    <div class="row">
        <label class="form-label">Permisos del Rol</label>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-3">
            @foreach ($permisos as $permiso)
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox"
                        wire:model="selectedPermissions.{{ $permiso['id'] }}" value="{{ $permiso['id'] }}">
                    {{ $permiso['name'] }}
                </label>
            @endforeach
        </div>
    </div>
</form>
