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


use Image;
/*
use Illuminate\Support\Facades\DB;
use Illuminate\Facades\Storage;
use Symfony\Component\HttpFoundation\Response; 
*/

class CursoController extends Controller
{
	public function saveImage(Request $request)
    {
			if($request->hasFile("image")) {
				$imagen = $request->file("image");
				$nombreimagen = $request->name_image;
				//$nombreimagen = $imagen->getClientOriginalName();
				$ruta = public_path("img/");
				
				$validator = Validator::make($request->all(), [
					'image' => 'dimensions:min_width=100,min_height=200|max:200',
				]);

				if($validator->passes()) {
					copy($imagen->getRealPath(),$ruta.$nombreimagen. "." .$imagen->guessExtension());
					$jsonResult = array(
						'estado' => true,
						'messague' => 'La imagen se subió con exito'
					);
				} else {
					$jsonResult = array(
						'estado' => false,
						'messague' => 'La imagen debe ser mínimo 100 pixeles de alto y 200 pixeles de ancho, con un peso de 200 KB'
					);
				}
			} else {
				$jsonResult = array(
					'estado' => false,
					'messague' => 'No se a podido subir la imagen al servidor'
				);
			}
			
			return $jsonResult;
		}

		public function savePdf(Request $request)
    {
			if($request->hasFile("pdf")) {
				
				$pdf = $request->file("pdf");
				$nombrepdf = $request->name_pdf;
				$ruta = public_path("pdf/");
				copy($pdf->getRealPath(),$ruta.$nombrepdf. "." .$pdf->guessExtension());
					$jsonResult = array(
						'estado' => true,
						'messague' => 'El pdf se subió con exito'
					);
			} else {
					$jsonResult = array(
						'estado' => false,
						'messague' => 'No se a podido subir pdf al servidor'
					);
			}
			return $jsonResult;
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
