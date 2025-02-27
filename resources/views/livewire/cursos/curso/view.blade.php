<div>
    <section>
        <div class="card">
            <div class="card-header pb-2">
                <h6 class="fw-normal text-sigro text-uppercase">Cursos</h6>
            </div>
            <div class="card-body mt-3">
                <div class="row justify-content-between">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary mb-4 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#crear_curso">NUEVO REGISTRO</button>
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
                                <th scope="col">DESCRIPCIÓN</th>
                                <th scope="col">PRECIO</th>
                                <th scope="col">ESTADO</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($cursos->count() == 0)
                                <tr>
                                    <td colspan="26" class="text-center text-muted fw-light pb-5 pt-5">
                                        <div>
                                            <i class="bi bi-clipboard-x" style="font-size: 3.5em"></i>
                                            <p class="fs-4">No hay resultados para mostrar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($cursos as $curso)
                                    <tr>
                                        <td>
                                            {!! $curso->id ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td>
                                            {!! $curso->nombre ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td>
                                            {!! $curso->descripcion ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td>
                                            {!! $curso->precio ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td>
                                            {!! $curso->estado->nombre ?? '<span class="text-eliminar fw-light">Campo vacío</span>' !!}
                                        </td>
                                        <td style="width: 160px;">
                                            <div class="nav">
                                                <a type="button" class="nav-link text-actualizar"
                                                    title="Editar Permiso" data-bs-toggle="modal"
                                                    data-bs-target="#editar_curso"
                                                    wire:click="edit({{ $curso->id }})">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a type="button" class="nav-link text-danger" title="Eliminar Permiso"
                                                    data-bs-toggle="modal" data-bs-target="#borrar_curso"
                                                    wire:click="delete_confirmation({{ $curso->id }})">
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
    @include('livewire.cursos.curso.modal')
</div>
@section('scripts')
    <script>
        document.addEventListener('close-modal', event => {
            $('#crear_curso').modal('hide');
            $('#editar_curso').modal('hide');
            $('#borrar_curso').modal('hide');
        });
        document.getElementById('cursos').classList.remove('collapsed');
    </script>
@endsection
