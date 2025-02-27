<div>
    <section>
        <div class="card">
            <div class="card-header pb-2">
                <h6 class="fw-normal text-sigro text-uppercase">Estados</h6>
            </div>
            <div class="card-body mt-3">
                <div class="row justify-content-between">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary mb-4 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#crear_estado">NUEVO REGISTRO</button>
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
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($estados->count() == 0)
                                <tr>
                                    <td colspan="26" class="text-center text-muted fw-light pb-5 pt-5">
                                        <div>
                                            <i class="bi bi-clipboard-x" style="font-size: 3.5em"></i>
                                            <p class="fs-4">No hay resultados para mostrar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($estados as $estado)
                                    <tr>
                                        <td>
                                            {!! $estado->id ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td>
                                            {!! $estado->nombre ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td style="width: 160px;">
                                            <div class="nav">
                                                <a type="button" class="nav-link text-actualizar"
                                                    title="Editar Estado" data-bs-toggle="modal"
                                                    data-bs-target="#editar_estado"
                                                    wire:click="edit({{ $estado->id }})">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a type="button" class="nav-link text-danger" title="Eliminar Estado"
                                                    data-bs-toggle="modal" data-bs-target="#borrar_estado"
                                                    wire:click="delete_confirmation({{ $estado->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- Fin Tabla -->
            </div>
        </div>
    </section>

    {{-- MODALES --}}
    @include('livewire.cursos.estados.modal')
</div>
@section('scripts')
    <script>
        document.addEventListener('close-modal', event => {
            $('#crear_estado').modal('hide');
            $('#editar_estado').modal('hide');
            $('#borrar_estado').modal('hide');
        });
        document.getElementById('estados').classList.remove('collapsed');
    </script>
@endsection
