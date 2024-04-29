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

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
/*
use Illuminate\Support\Facades\DB;
use Illuminate\Facades\Storage;
use Symfony\Component\HttpFoundation\Response; 
*/

class CursoController extends Controller
{
	public function saveImage(Request $request)
    {
			/*
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Headers: *");
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			header("Allow: GET, POST, OPTIONS, PUT, DELETE");
			*/
			//var_dump($request);
			//$img = $request->image;
			//$file = $request[0];

			
			
			if($request->hasFile("image")) {
				echo "SI";
			} else {
				echo "NO";
			}
			/*
			var_dump($_POST);

			if(isset($_FILES['image'])) {
				//$tamanio = $_FILES['image']['size'];
				echo "SI";
			} else {
				echo "NO";
			}
			*/

			//$extension = $request->image;
			return 1;
			/*
			if($request->hasFile("image")) {
				$imagen = $request->file("image");                        
				//$nombreimagen = $imagen->getClientOriginalName();
				return $imagen;
			} else {
				return "NO";
			}
			*/
		}

    public function index()
    {
				$cursos = Curso::select('cursos.*', 'periodos.anio', 'categorias.categoria')
				->join('periodos', 'periodos.cod_periodo', '=', 'cursos.cod_periodo')
				->join('categorias', 'categorias.cod_categoria', '=', 'cursos.cod_categoria')
				->orderBy('cod_curso','desc')->get();
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
        $curso->cod_periodo = $request->cod_periodo;
        $curso->cod_categoria = $request->cod_categoria;
				$curso->nombre_curso = $request->nombre_curso;
				$curso->imagen_curso = $request->imagen_curso;
				$curso->fecha_inicio_inscripcion = $request->fecha_inicio_inscripcion;
				$curso->fecha_fin_inscripcion = $request->fecha_fin_inscripcion;
				$curso->fecha_inicio = $request->fecha_inicio;
				$curso->fecha_fin = $request->fecha_fin;
				$curso->modalidad = $request->modalidad;
				$curso->cupo = $request->cupo;
				$curso->descripcion = $request->descripcion;
				$curso->documento_descripcion = $request->documento_descripcion;
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
        $curso->cod_periodo = $request->cod_periodo;
        $curso->cod_categoria = $request->cod_categoria;
				$curso->nombre_curso = $request->nombre_curso;
				$curso->imagen_curso = $request->imagen_curso;
				$curso->fecha_inicio_inscripcion = $request->fecha_inicio_inscripcion;
				$curso->fecha_fin_inscripcion = $request->fecha_fin_inscripcion;
				$curso->fecha_inicio = $request->fecha_inicio;
				$curso->fecha_fin = $request->fecha_fin;
				$curso->modalidad = $request->modalidad;
				$curso->cupo = $request->cupo;
				$curso->descripcion = $request->descripcion;
				$curso->documento_descripcion = $request->documento_descripcion;
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
