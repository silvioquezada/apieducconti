<?php
use App\Helpers\AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    $adminHelper = new AdminHelper();
    $user = $adminHelper->GetAuthUser();
    return response()->json(['data' => $user], 200);
});

//Route::get('/categorias', 'App\Http\Controllers\CategoriaController@index');

//Route::get('/usuarios', 'App\Http\Controllers\UsuarioController@index');

Route::get('/usuarios', [UsuarioController::class, 'index']);
