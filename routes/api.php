<?php
use App\Helpers\AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;

Route::post('/usuarios', [UsuarioController::class, 'save']);
Route::post('/usuarios/login', [UsuarioController::class, 'login']);
Route::get('/usuarios/searchcedula/{cedula}', [UsuarioController::class, 'searchCedula']);
Route::get('/usuarios/searchemail/{email}', [UsuarioController::class, 'searchEmail']);
Route::get('/usuarios/searchuser/{user}', [UsuarioController::class, 'searchUser']);

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('/usuarios/searchrowuser', [UsuarioController::class, 'searchRowUser']);
    Route::put('/usuarios', [UsuarioController::class, 'update']);
    Route::get('/usuariosmanager', [UsuarioController::class, 'index']);
    Route::post('/usuariosmanager', [UsuarioController::class, 'saveManager']);
    Route::put('/usuariosmanager', [UsuarioController::class, 'updateManager']);
    Route::put('/usuariosmanager/delete', [UsuarioController::class, 'destroyManager']);
    
    //Route::get('/categorias', 'App\Http\Controllers\CategoriaController@index');
});