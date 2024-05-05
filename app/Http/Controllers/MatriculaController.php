<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Handlers\Admin\AuthHandler;
use App\Models\Matricula;
use App\Models\Curso;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PublicHelper;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MatriculaController extends Controller
{
    public function index($cod_periodo, $estado_matricula)
    {
        //return $cod_periodo . ' - ' . $estado_matricula;
        $matriculas = Matricula::with("Curso")->where('matriculas.cod_periodo', $cod_periodo)->where('matriculas.estado_matricula', $estado_matricula)->where('matriculas.estado', 1)->orderBy('matriculas.cod_matricula','desc')->get();
        return $matriculas;
    }

    public function searchEnrolledCourse($cod_curso)
    {
	    $publicHelper = new PublicHelper();
        $token = $publicHelper->GetAndDecodeJWT();
        $userID = $token->data->userID;

        $json = Matricula::where('cod_usuario', $userID)->where('cod_curso', $cod_curso)->where('estado', 1)->get();
        if($json->isEmpty())
				{
					$jsonResult = array(
						'estado' => false
					);
				}
        else
        {
            $jsonResult = array(
							'estado' => true
						);
        }
		
        return $jsonResult;
    }

    public function savePdf(Request $request)
    {
        if($request->hasFile("pdf")) {
            $pdf = $request->file("pdf");
            $nombrepdf = $request->name_pdf;
            $ruta = public_path("requirementpdf/");
            copy($pdf->getRealPath(),$ruta.$nombrepdf. "." .$pdf->guessExtension());
                $jsonResult = array(
                    'estado' => true,
                    'messague' => 'El pdf se subió con exito',
                    'file' => $nombrepdf. "." .$pdf->guessExtension()
                );
        } else {
                $jsonResult = array(
                    'estado' => false,
                    'messague' => 'No se a podido subir pdf al servidor'
                );
        }
        return $jsonResult;
    }

    public function save(Request $request)
    {
        $publicHelper = new PublicHelper();
        $token = $publicHelper->GetAndDecodeJWT();
        $userID = $token->data->userID;
        
        $matricula = new Matricula();
        $matricula->cod_matricula = $request->cod_matricula;
        date_default_timezone_set('America/Guayaquil');
		$fecha_registro = date("Y-m-d H:i:s");
        $matricula->fecha_registro = $fecha_registro;
        $matricula->cod_curso = $request->cod_curso;
        $matricula->cod_usuario = $userID;
        $matricula->documento_descripcion = $request->documento_descripcion;
        $matricula->estado = 1;
        
        $row = $matricula->save();
        if($row==true)
        {
            $json = array(
                    'estado' => 1,
                    'descripcion' => 'Registro almacenado correctamente'
            );
        }
        else
        {
            $json = array(
                    'estado' => 0,
                    'descripcion' => 'Registro no se pudo almacenar correctamente'
            );
        }
        echo json_encode($json);
    }

    public function update(Request $request)
    {
        $matricula  = Matricula::find($request->cod_matricula);
        $matricula->documento_descripcion = $request->documento_descripcion;
        $matricula->estado = 1;
        
        $row = $matricula->save();
        if($row==true)
        {
            $json = array(
                    'estado' => 1,
                    'descripcion' => 'Registro actualizado correctamente'
            );
        }
        else
        {
            $json = array(
                    'estado' => 0,
                    'descripcion' => 'Registro no se pudo actualizar correctamente'
            );
        }
        echo json_encode($json);
    }

    public function myCourses()
    {
        $publicHelper = new PublicHelper();
        $token = $publicHelper->GetAndDecodeJWT();
        $userID = $token->data->userID;

        $matriculas = Matricula::with("Curso")->where('matriculas.cod_usuario', $userID)->where('matriculas.estado', 1)->orderBy('matriculas.cod_matricula','desc')->get();
        return $matriculas;
    }

}
