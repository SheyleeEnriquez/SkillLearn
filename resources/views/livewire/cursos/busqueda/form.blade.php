<form>
    <div class="row">
        <div class="col-sm-5 mb-3">
            <label class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control form-control" wire:model="fecha_inicio">
            @error('fecha_inicio')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
        <div class="col-sm-5 mb-3">
            <label class="form-label">Fecha Fin</label>
            <input type="date" class="form-control form-control" wire:model="fecha_fin">
            @error('fecha_fin')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
    </div>
</form>
