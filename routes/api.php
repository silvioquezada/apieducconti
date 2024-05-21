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

Route::get('/categorias', [CategoriaController::class, 'index']);

Route::get('/cursos/list', [CursoController::class, 'listCourse']);
Route::get('/cursos/listcourseoffer', [CursoController::class, 'listCourseOffer']);
Route::get('/cursos/detail/{cod_curso}', [CursoController::class, 'detailCourse']);
Route::get('/cursos/listcoursecategory/{cod_categoria}', [CursoController::class, 'listCourseCategory']);

Route::get('/matriculas/verifyquotas/{cod_curso}', [MatriculaController::class, 'verifyQuotas']);

Route::get('/requisitos', [RequisitoController::class, 'index']);

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('/usuarios/searchrowuser', [UsuarioController::class, 'searchRowUser']);
    Route::put('/usuarios', [UsuarioController::class, 'update']);
    Route::get('/usuarios/manager', [UsuarioController::class, 'index']);
    Route::post('/usuarios/manager', [UsuarioController::class, 'saveManager']);
    Route::put('/usuarios/manager', [UsuarioController::class, 'updateManager']);
    Route::put('/usuarios/manager/delete', [UsuarioController::class, 'destroyManager']);
    
    Route::get('/periodos', [PeriodoController::class, 'index']);
    Route::post('/periodos', [PeriodoController::class, 'save']);
    Route::get('/periodos/searchcodeperiod/{codigo_periodo}', [PeriodoController::class, 'searchCodePeriod']);
    Route::put('/periodos', [PeriodoController::class, 'update']);
    Route::put('/periodos/delete', [PeriodoController::class, 'destroy']);

    Route::post('/categorias', [CategoriaController::class, 'save']);
    Route::get('/categorias/searchcategory/{categoria}', [CategoriaController::class, 'searchCategory']);
    Route::put('/categorias', [CategoriaController::class, 'update']);
    Route::put('/categorias/delete', [CategoriaController::class, 'destroy']);

    Route::get('/cursos', [CursoController::class, 'index']);
    Route::post('/cursos/image', [CursoController::class, 'saveImage']);
    Route::post('/cursos/pdf', [CursoController::class, 'savePdf']);
    Route::post('/cursos', [CursoController::class, 'save']);
    Route::get('/cursos/searchcodecourse/{codigo_curso}', [CursoController::class, 'searchCodeCourse']);
    Route::put('/cursos', [CursoController::class, 'update']);
    Route::put('/cursos/delete', [CursoController::class, 'destroy']);
    Route::get('/cursos/listcourseperiod/{cod_periodo}', [CursoController::class, 'listCoursePeriod']);
    Route::put('/cursos/hideoffer', [CursoController::class, 'hideOffer']);
    Route::put('/cursos/viewoffer', [CursoController::class, 'viewOffer']);

    Route::get('/matriculas/mycourses', [MatriculaController::class, 'myCourses']);
    Route::get('/matriculas/searchenrolledcourse/{cod_curso}', [MatriculaController::class, 'searchEnrolledCourse']);
    Route::post('/matriculas', [MatriculaController::class, 'save']);
    Route::post('/matriculas/pdf', [MatriculaController::class, 'savePdf']);
    Route::put('/matriculas', [MatriculaController::class, 'update']);

    Route::get('/matriculas/listinscriptions/{cod_periodo}/{estado_matricula}', [MatriculaController::class, 'index']);
    Route::get('/matriculas/listallestudentscourse/{cod_periodo}', [MatriculaController::class, 'listAllEstudentsCourse']);
    Route::get('/matriculas/listestudentscourse/{cod_curso}', [MatriculaController::class, 'listEstudentsCourse']);
    Route::put('/matriculas/sendobservation', [MatriculaController::class, 'sendObservation']);
    Route::put('/matriculas/enroll', [MatriculaController::class, 'enroll']);
    Route::put('/matriculas/delete', [MatriculaController::class, 'destroy']);
    
    Route::put('/matriculas/approve', [MatriculaController::class, 'approve']);
    Route::post('/matriculas/pdfcertificate', [MatriculaController::class, 'savePdfCertificate']);
    Route::put('/matriculas/updatepdfcertificate', [MatriculaController::class, 'updatePdfCertificate']);

    Route::get('/matriculas/listallestudentscourseinscribed/{cod_periodo}', [MatriculaController::class, 'listAllEstudentsCourseInscribed']);
    Route::get('/matriculas/listallestudentscourseinscribedstatus/{cod_periodo}/{estado_matricula}', [MatriculaController::class, 'listAllEstudentsCourseInscribedStatus']);
    Route::get('/matriculas/listestudentscourseinscribed/{cod_curso}/{estado_matricula}', [MatriculaController::class, 'listEstudentsCourseInscribed']);
    Route::get('/matriculas/listallestudentscourseinscribedallstatus/{cod_curso}', [MatriculaController::class, 'listAllEstudentsCourseInscribedAllStatus']);

    Route::get('/matriculas/listallestudentscourseapprove/{cod_periodo}', [MatriculaController::class, 'listAllEstudentsCourseApprove']);
    Route::get('/matriculas/listallestudentscourseapprovestatus/{cod_periodo}/{estado_aprobacion}', [MatriculaController::class, 'listAllEstudentsCourseApproveStatus']);
    Route::get('/matriculas/listestudentscourseapprove/{cod_curso}/{estado_aprobacion}', [MatriculaController::class, 'listEstudentsCourseApprove']);
    Route::get('/matriculas/listallestudentscourseapproveallstatus/{cod_curso}', [MatriculaController::class, 'listAllEstudentsCourseApproveAllStatus']);

    Route::get('/requisitos/search', [RequisitoController::class, 'search']);
    Route::put('/requisitos', [RequisitoController::class, 'update']);
});