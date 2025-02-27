@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('content')
<div class="pagetitle">
    <h3>USUARIOS</h3>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Inicio</li>
            <li class="breadcrumb-item active">Usuarios</li>
        </ol>
    </nav>
</div> 
@livewire('usuarios.usuario.usuario')
@endsection 