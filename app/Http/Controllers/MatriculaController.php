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
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('cursos.cod_periodo', $cod_periodo)
                ->where('matriculas.estado_matricula', $estado_matricula)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
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
        $matricula->estado_matricula = 2;//Por respuesta
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

    public function sendObservation(Request $request)
    {
        $matricula  = Matricula::find($request->cod_matricula);
        $matricula->observacion_revision = $request->observacion_revision;
        $matricula->estado_matricula = 1;//Por rectificar
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

    public function enroll(Request $request)
    {
        $matricula  = Matricula::find($request->cod_matricula);
        $matricula->estado_matricula = 3;//Aprobado
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

    public function destroy(Request $request)
    {
        $matricula  = Matricula::find($request->cod_matricula);
        $matricula->estado = 0;
        $row = $matricula->save();
			if($row==true)
			{
				$json = array(
						'estado' => 1,
						'descripcion' => 'Registro eliminado satisfactoriamente'
				);
			}
			else
			{
				$json = array(
						'estado' => 0,
						'descripcion' => 'Registro no se pudo eliminar'
				);
			}
			echo json_encode($json);
    }

    public function listAllEstudentsCourse($cod_periodo)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('cursos.cod_periodo', $cod_periodo)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function listEstudentsCourse($cod_curso)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_aprobacion', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('matriculas.cod_curso', $cod_curso)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function approve(Request $request)
    {
        $matricula  = Matricula::find($request->cod_matricula);
        $matricula->estado_aprobacion = $request->estado_aprobacion;
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

    public function savePdfCertificate(Request $request)
    {
        if($request->hasFile("pdf")) {
            $pdf = $request->file("pdf");
            $nombrepdf = $request->name_pdf;
            $ruta = public_path("certificatepdf/");
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

    public function updatePdfCertificate(Request $request)
    {
        $matricula  = Matricula::find($request->cod_matricula);
        $matricula->archivo_certificado = $request->archivo_certificado;
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

    public function listAllEstudentsCourseApprove($cod_periodo)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('cursos.cod_periodo', $cod_periodo)
                ->where('matriculas.estado_matricula', 3)
                ->whereNot('matriculas.estado_aprobacion', 0)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function listAllEstudentsCourseApproveStatus($cod_periodo, $estado_aprobacion)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('cursos.cod_periodo', $cod_periodo)
                ->where('matriculas.estado_aprobacion', $estado_aprobacion)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function listEstudentsCourseApprove($cod_curso, $estado_aprobacion)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('matriculas.cod_curso', $cod_curso)
                ->where('matriculas.estado_aprobacion', $estado_aprobacion)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function listAllEstudentsCourseApproveAllStatus($cod_curso)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('matriculas.cod_curso', $cod_curso)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }




    public function listAllEstudentsCourseInscribed($cod_periodo)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_matricula', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('cursos.cod_periodo', $cod_periodo)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function listAllEstudentsCourseInscribedStatus($cod_periodo, $estado_matricula)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_matricula', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('cursos.cod_periodo', $cod_periodo)
                ->where('matriculas.estado_matricula', $estado_matricula)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function listEstudentsCourseInscribed($cod_curso, $estado_matricula)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_matricula', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('matriculas.cod_curso', $cod_curso)
                ->where('matriculas.estado_matricula', $estado_matricula)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

    public function listAllEstudentsCourseInscribedAllStatus($cod_curso)
    {
        $matriculas = Matricula::select('matriculas.cod_matricula', 'cursos.nombre_curso', 'usuarios.correo', 'usuarios.celular', 'matriculas.observacion_revision', 'matriculas.documento_descripcion', 'matriculas.estado_matricula', 'matriculas.estado_aprobacion', 'matriculas.archivo_certificado', 'usuarios.cedula', 'usuarios.apellido', 'usuarios.nombre')->selectRaw("concat(usuarios.apellido, ' ', usuarios.nombre) as usuario")
				->join('usuarios', 'usuarios.cod_usuario', '=', 'matriculas.cod_usuario')
				->join('cursos', 'cursos.cod_curso', '=', 'matriculas.cod_curso')
                ->where('matriculas.cod_curso', $cod_curso)
				->where('matriculas.estado', 1)->orderBy('cod_matricula','desc')->get();
        return $matriculas;
    }

}
