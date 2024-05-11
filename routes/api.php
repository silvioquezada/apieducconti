<?php
use App\Helpers\AdminHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\RequisitoController;

Route::post('/usuarios', [UsuarioController::class, 'save']);
Route::post('/usuarios/login', [UsuarioController::class, 'login']);
Route::get('/usuarios/searchcedula/{cedula}', [UsuarioController::class, 'searchCedula']);
Route::get('/usuarios/searchemail/{email}', [UsuarioController::class, 'searchEmail']);
Route::get('/usuarios/searchuser/{user}', [UsuarioController::class, 'searchUser']);
Route::put('/usuarios/recoverpassword', [UsuarioController::class, 'recoverPassword']);

Route::get('/curso/list', [CursoController::class, 'listCourse']);
Route::get('/curso/detail/{cod_curso}', [CursoController::class, 'detailCourse']);
Route::get('/curso/listcoursecategory/{cod_categoria}', [CursoController::class, 'listCourseCategory']);

Route::get('/matricula/searchenrolledcourse/{cod_curso}', [MatriculaController::class, 'searchEnrolledCourse']);
Route::post('/matricula', [MatriculaController::class, 'save']);
Route::post('/matricula/pdf', [MatriculaController::class, 'savePdf']);

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

    Route::get('/categoria', [CategoriaController::class, 'index']);
    Route::post('/categoria', [CategoriaController::class, 'save']);
    Route::get('/categoria/searchcategory/{categoria}', [CategoriaController::class, 'searchCategory']);
    Route::put('/categoria', [CategoriaController::class, 'update']);
    Route::put('/categoria/delete', [CategoriaController::class, 'destroy']);

    Route::get('/curso', [CursoController::class, 'index']);
    Route::post('/curso/image', [CursoController::class, 'saveImage']);
    Route::post('/curso/pdf', [CursoController::class, 'savePdf']);
    Route::post('/curso', [CursoController::class, 'save']);
    Route::get('/curso/searchcodecourse/{codigo_curso}', [CursoController::class, 'searchCodeCourse']);
    Route::put('/curso', [CursoController::class, 'update']);
    Route::put('/curso/delete', [CursoController::class, 'destroy']);
    Route::get('/curso/listcourseperiod/{cod_periodo}', [CursoController::class, 'listCoursePeriod']);

    Route::get('/matricula/mycourses', [MatriculaController::class, 'myCourses']);
    Route::put('/matricula', [MatriculaController::class, 'update']);
    Route::get('/matricula/listinscriptions/{cod_periodo}/{estado_matricula}', [MatriculaController::class, 'index']);
    Route::put('/matricula/sendobservation', [MatriculaController::class, 'sendObservation']);
    Route::put('/matricula/enroll', [MatriculaController::class, 'enroll']);
    Route::put('/matricula/delete', [MatriculaController::class, 'destroy']);
    Route::get('/matricula/listallestudentscourse/{cod_periodo}', [MatriculaController::class, 'listAllEstudentsCourse']);
    Route::get('/matricula/listestudentscourse/{cod_curso}', [MatriculaController::class, 'listEstudentsCourse']);
    Route::put('/matricula/approve', [MatriculaController::class, 'approve']);
    Route::post('/matricula/pdfcertificate', [MatriculaController::class, 'savePdfCertificate']);
    Route::put('/matricula/updatepdfcertificate', [MatriculaController::class, 'updatePdfCertificate']);

    Route::get('/matricula/listallestudentscourseapprove/{cod_periodo}', [MatriculaController::class, 'listAllEstudentsCourseApprove']);
    Route::get('/matricula/listallestudentscourseapprovestatus/{cod_periodo}/{estado_aprobacion}', [MatriculaController::class, 'listAllEstudentsCourseApproveStatus']);
    Route::get('/matricula/listestudentscourseapprove/{cod_curso}/{estado_aprobacion}', [MatriculaController::class, 'listEstudentsCourseApprove']);
    Route::get('/matricula/listallestudentscourseapproveallstatus/{cod_curso}', [MatriculaController::class, 'listAllEstudentsCourseApproveAllStatus']);

    Route::get('/matricula/listallestudentscourseinscribed/{cod_periodo}', [MatriculaController::class, 'listAllEstudentsCourseInscribed']);
    Route::get('/matricula/listallestudentscourseinscribedstatus/{cod_periodo}/{estado_matricula}', [MatriculaController::class, 'listAllEstudentsCourseInscribedStatus']);
    Route::get('/matricula/listestudentscourseinscribed/{cod_curso}/{estado_matricula}', [MatriculaController::class, 'listEstudentsCourseInscribed']);
    Route::get('/matricula/listallestudentscourseinscribedallstatus/{cod_curso}', [MatriculaController::class, 'listAllEstudentsCourseInscribedAllStatus']);

    Route::get('/requisitos', [RequisitoController::class, 'index']);
    Route::put('/requisitos', [RequisitoController::class, 'update']);
});