<div>
    <section>
        <div class="card">
            <div class="card-header pb-2">
                <h6 class="fw-normal text-sigro text-uppercase">Cursos Inscritos</h6>
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
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($cursos as $curso)
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/' . $curso->foto) }}" class="mt-2"
                                        style="max-width: 150px;" alt="Imagen almacenada">
                                    <h5 class="card-title">Nombre: {{ $curso->nombre ?? 'Campo vacío' }}</h5>
                                    <p class="card-text">Descripción: {{ $curso->descripcion ?? 'Campo vacío' }}</p>
                                    <p class="card-text">Precio: {{ $curso->precio ?? 'Campo vacío' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@section('scripts')
    <script>
        document.addEventListener('close-modal', event => {
            $('#registrar_suscripcion').modal('hide');
            $('#editar_curso').modal('hide');
            $('#borrar_curso').modal('hide');
        });
        document.getElementById('cursos-inscritos').classList.remove('collapsed');
    </script>
@endsection
