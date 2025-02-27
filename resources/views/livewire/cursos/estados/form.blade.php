<form>
    <div class="row">
        <div class="col-sm-5 mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control form-control" wire:model="nombre">
            @error('nombre')
                <span class="error text-danger"><small>Campo obligatorio</small></span>
            @enderror
        </div>
    </div>
</form>
