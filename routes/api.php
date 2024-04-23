<?php
use App\Helpers\AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;

Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::post('/usuarios/login', [UsuarioController::class, 'login']);
Route::get('/usuarios/searchcedula/{cedula}', [UsuarioController::class, 'searchCedula']);
Route::get('/usuarios/searchemail/{email}', [UsuarioController::class, 'searchEmail']);
Route::get('/usuarios/searchuser/{user}', [UsuarioController::class, 'searchUser']);

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('/usuarios/searchrowuser', 'App\Http\Controllers\UsuarioController@searchRowUser');
    Route::put('/usuarios', 'App\Http\Controllers\UsuarioController@update');
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    
    Route::get('/categorias', 'App\Http\Controllers\CategoriaController@index');
});