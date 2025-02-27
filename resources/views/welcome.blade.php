@extends('layouts.app')
@section('content')
<section id="hero-welcome" class="d-flex align-items-center">
    <div style="display: flex; justify-content: center; align-items: center; width: 100%; position: relative;">
        <div style="width: 80%; height: 400px; overflow: hidden; position: relative;">
            <div style="position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%); z-index: 2;">
                <h1 class="fw-bold text-dark">BIENVENIDO</h1>
            </div>
            <div style="position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 2;">
                <h1 class="fw-bold text-dark">AL SISTEMA WEB DE SKILL LEARN</h1>
            </div>
        </div>
    </div>
</section>
@endsection