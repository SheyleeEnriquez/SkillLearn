<div>
    <section>
        <div class="card">
            <div class="card-header pb-2">
                <h6 class="fw-normal text-sigro text-uppercase">Perfil</h6>
            </div>
            <div class="card-body mt-3">
                <div class="row justify-content-between">
                    <div class="col-md-4">
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control form-control" wire:model="nombre">
                        @error('nombre')
                            <span class="error text-danger"><small>Campo obligatorio</small></span>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label">Contraseña Anterior</label>
                        <input type="password" class="form-control form-control" wire:model="contrasena_anterior">
                        @error('contrasena_anterior')
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
                <div class="modal-footer justify-content-center">
                    <button type="button" wire:click.prevent="updateProfile()" class="btn btn-primary">GUARDAR</button>
                    <a type="button" href="{{ route('home') }}" class="btn btn-danger ms-3">CANCELAR</a>
                </div>
            </div>
        </div>
    </section>
</div>
