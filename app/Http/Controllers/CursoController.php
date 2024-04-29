<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Handlers\Admin\AuthHandler;
use App\Models\Curso;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PublicHelper;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::where('estado', 1)->orderBy('cod_curso','desc')->get();
        return $cursos;
    }

    public function searchCodeCourse($codigo_curso)
    {
        $json = Curso::where('codigo_curso', $codigo_curso)->where('estado', 1)->get();
        
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

    public function save(Request $request)
    {
        $curso = new Curso();
        $curso->cod_curso = $request->cod_curso;
        $curso->codigo_curso = $request->codigo_curso;
        $curso->anio = $request->anio;
        $curso->descripcion = $request->descripcion;
        $curso->estado = 1;
        
        $row = $curso->save();
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
        $curso  = Curso::find($request->cod_curso);
        $curso->codigo_curso = $request->codigo_curso;
        $curso->anio = $request->anio;
        $curso->descripcion = $request->descripcion;
        $curso->estado = 1;
        
        $row = $curso->save();
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

    public function destroy(Request $request)
    {
        $curso  = Curso::find($request->cod_curso);
        $curso->estado = 0;
        
        $row = $curso->save();
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
}
