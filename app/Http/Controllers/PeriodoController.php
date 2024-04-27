<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Handlers\Admin\AuthHandler;
use App\Models\Periodo;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PublicHelper;

class PeriodoController extends Controller
{
    public function index()
    {
        $periodos = Periodo::where('estado', 1)->orderBy('cod_periodo','desc')->get();
        return $periodos;
    }

    public function searchCodePeriod($codigo_periodo)
    {
        $json = Periodo::where('codigo_periodo', $codigo_periodo)->where('estado', 1)->get();
        
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
        $periodo = new Periodo();
        $periodo->cod_periodo = $request->cod_periodo;
        $periodo->codigo_periodo = $request->codigo_periodo;
        $periodo->anio = $request->anio;
        $periodo->descripcion = $request->descripcion;
        $periodo->estado = 1;
        
        $row = $periodo->save();
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
        $periodo  = Periodo::find($request->cod_periodo);
        $periodo->codigo_periodo = $request->codigo_periodo;
        $periodo->anio = $request->anio;
        $periodo->descripcion = $request->descripcion;
        $periodo->estado = 1;
        
        $row = $periodo->save();
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
        $periodo  = Periodo::find($request->cod_periodo);
        $periodo->estado = 0;
        
        $row = $periodo->save();
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
