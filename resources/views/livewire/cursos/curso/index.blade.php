@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('content')
    <div class="pagetitle">
        <h3>CURSOS</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Inicio</li>
                <li class="breadcrumb-item active">Cursos</li>
            </ol>
        </nav>
    </div>
    @livewire('cursos.curso.curso')
@endsection
