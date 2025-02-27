@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('content')
    <div class="pagetitle">
        <h3>Suscripciones</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Inicio</li>
                <li class="breadcrumb-item active">Suscripciones</li>
            </ol>
        </nav>
    </div>
    @livewire('cursos.suscripcion.suscripcion')
@endsection
