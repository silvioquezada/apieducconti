<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Handlers\Admin\AuthHandler;
use App\Models\Requisito;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PublicHelper;

class RequisitoController extends Controller
{
    public function index()
    {
        $requisito = Requisito::where('cod_requisitos', 1)->get();
        return $requisito[0];
    }

    public function update(Request $request)
    {
        $requisito  = Requisito::find($request->cod_requisitos);
        $requisito->requisitos = $request->requisitos;
        
        $row = $requisito->save();
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
}
