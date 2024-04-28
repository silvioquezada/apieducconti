<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Handlers\Admin\AuthHandler;
use App\Models\Categoria;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PublicHelper;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('estado', 1)->orderBy('cod_categoria','desc')->get();
        return $categorias;
    }

    public function searchCategory($categoria)
    {
        $json = Categoria::where('categoria', $categoria)->where('estado', 1)->get();
        
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
        $categoria = new Categoria();
        $categoria->cod_categoria = $request->cod_categoria;
        $categoria->categoria = $request->categoria;
        $categoria->estado = 1;
        
        $row = $categoria->save();
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
        $categoria  = Categoria::find($request->cod_categoria);
        $categoria->categoria = $request->categoria;
        $categoria->estado = 1;
        
        $row = $categoria->save();
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
        $categoria  = Categoria::find($request->cod_categoria);
        $categoria->estado = 0;
        
        $row = $categoria->save();
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
