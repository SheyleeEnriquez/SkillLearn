<li class="nav-heading">Proyecto Cursos</li>
<li>
    @can('administrador')
    <li class="nav-item">
        <a class="nav-link collapsed" id="usuarios" href="{{ route('usuarios') }}">
            <i class="fas fa-user me-3"></i><span>Usuarios</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" id="permisos" href="{{ route('permisos') }}">
            <i class="fas fa-user-shield me-3"></i><span>Permisos</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" id="roles" href="{{ route('roles') }}">
            <i class="fas fa-user-tag me-3"></i><span>Roles</span>
        </a>
    </li>
@endcan
@can('profesor')
<li class="nav-item">
    <a class="nav-link collapsed" id="cursos" href="{{ route('cursos') }}">
        <i class="fas fa-book me-3"></i><span>Gestión de Cursos</span>
    </a>
</li>
@endcan
@can('administrador')
<li class="nav-item">
    <a class="nav-link collapsed" id="suscripciones" href="{{ route('suscripciones') }}">
        <i class="fas fa-users me-3"></i><span>Gestión de Suscripciones</span>
    </a>
</li>    
@endcan
@can('administrador')
<li class="nav-item">
    <a class="nav-link collapsed" id="estados" href="{{ route('estados') }}">
        <i class="fas fa-flag me-3"></i><span>Gestión de Estados</span>
    </a>
</li>    
@endcan
<li class="nav-item">
    <a class="nav-link collapsed" id="busqueda-cursos" href="{{ route('busqueda-cursos') }}">
        <i class="fas fa-search me-3"></i><span>Búsqueda de Cursos</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" id="cursos-inscritos" href="{{ route('cursos-inscritos') }}">
        <i class="fas fa-certificate me-3"></i><span>Cursos Inscritos</span>
    </a>
</li>
