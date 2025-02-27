<?php

use App\Http\Controllers\Curso\CursoBusquedaController;
use App\Http\Controllers\Curso\CursoController;
use App\Http\Controllers\Curso\EstadoController;
use App\Http\Controllers\Curso\InscritoController;
use App\Http\Controllers\Curso\SuscripcionController;
use App\Http\Controllers\Usuarios\PerfilController;
use App\Http\Controllers\Usuarios\PermisoController;
use App\Http\Controllers\Usuarios\RolController;
use App\Http\Controllers\Usuarios\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//USUARIOS
Route::middleware(['auth', 'can:administrador'])->get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
Route::middleware(['auth', 'can:administrador'])->get('/permisos', [PermisoController::class, 'index'])->name('permisos');
Route::middleware(['auth', 'can:administrador'])->get('/roles', [RolController::class, 'index'])->name('roles');

Route::middleware('auth')->get('/perfil', [PerfilController::class, 'index'])->name('perfil');

//CURSOS
Route::middleware(['auth', 'can:profesor,administrador'])->get('/cursos', [CursoController::class, 'index'])->name('cursos');
Route::middleware(['auth', 'can:administrador'])->get('/suscripciones', [SuscripcionController::class, 'index'])->name('suscripciones');
Route::middleware(['auth', 'can:administrador'])->get('/estados', [EstadoController::class, 'index'])->name('estados');
Route::middleware('auth')->get('/busqueda-cursos', [CursoBusquedaController::class, 'index'])->name('busqueda-cursos');
Route::middleware('auth')->get('/cursos-inscritos', [InscritoController::class, 'index'])->name('cursos-inscritos');


