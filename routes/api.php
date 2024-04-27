<?php
use App\Helpers\AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\CategoriaController;

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
    
    Route::get('/periodo', [PeriodoController::class, 'index']);
    Route::post('/periodo', [PeriodoController::class, 'save']);
    Route::get('/periodo/searchcodeperiod/{codigo_periodo}', [PeriodoController::class, 'searchCodePeriod']);
    Route::put('/periodo', [PeriodoController::class, 'update']);
    Route::put('/periodo/delete', [PeriodoController::class, 'destroy']);
});