<?php

use Illuminate\Support\Facades\Route;
use App\Models\Curso;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    $cursos = Curso::all();
    return view('formulario',compact('cursos'));
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('inscritos', \App\Http\Controllers\InscritosController::class);

Route::group(['middleware' => ['auth']], function () {
    Route::resource('/roles', \App\Http\Controllers\RolController::class);
    Route::resource('/usuarios',\App\Http\Controllers\UsuarioController::class);
   
    Route::resource('/cursos', \App\Http\Controllers\CursosController::class);
    // Route::resource('roles', \App\Http\Controllers\RoleController::class);
}); 