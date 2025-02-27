@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('content')
<div class="pagetitle">
    <h3>ROLES</h3>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Inicio</li>
            <li class="breadcrumb-item active">Roles</li>
        </ol>
    </nav>
</div> 
@livewire('usuarios.rol.rol')
@endsection 