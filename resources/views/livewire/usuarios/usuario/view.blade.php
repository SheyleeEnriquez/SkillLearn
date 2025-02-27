<div>
    <section>
        <div class="card">
            <div class="card-header pb-2">
                <h6 class="fw-normal text-sigro text-uppercase">Usuarios</h6>
            </div>
            <div class="card-body mt-3">
                <div class="row justify-content-between">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary mb-4 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#crear_usuario">NUEVO REGISTRO</button>
                    </div>
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
                <!-- Tabla -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle text-uppercase pt-2 pb-2">
                        <thead class="table-success">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">USUARIO</th>
                                <th scope="col">ROL</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @empty($usuarios)
                                <tr>
                                    <td colspan="26" class="text-center text-muted fw-light pb-5 pt-5">
                                        <div>
                                            <i class="bi bi-clipboard-x" style="font-size: 3.5em"></i>
                                            <p class="fs-4">No hay resultados para mostrar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>
                                            {!! $usuario['id'] ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td>
                                            {!! $usuario['name'] ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td>
                                            {!! $usuario['email'] ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        @php
                                            $user = App\Models\User::findOrFail($usuario['id']);
                                            $rol = $user->roles()->first();
                                        @endphp
                                        <td>
                                            {!! $rol->name ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td style="width: 160px;">
                                            <div class="nav">
                                                <a type="button" class="nav-link text-actualizar" title="Cambiar Rol"
                                                    data-bs-toggle="modal" data-bs-target="#cambiar_rol"
                                                    wire:click="usuarioRol({{ $usuario['id'] }})">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a type="button" class="nav-link text-danger" title="Eliminar Usuario"
                                                    data-bs-toggle="modal" data-bs-target="#borrar_usuario"
                                                    wire:click="delete_confirmation({{ $usuario['id'] }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endempty
                        </tbody>
                    </table>
                </div>
                <!-- Fin Tabla -->
            </div>
        </div>
    </section>

    {{-- MODALES --}}
    @include('livewire.usuarios.usuario.modal')
</div>
@section('scripts')
    <script>
        document.addEventListener('close-modal', event => {
            $('#crear_usuario').modal('hide');
            $('#cambiar_rol').modal('hide');
            $('#borrar_usuario').modal('hide');
        });
        document.getElementById('usuarios').classList.remove('collapsed');
    </script>
@endsection
