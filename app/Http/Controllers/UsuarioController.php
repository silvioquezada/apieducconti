<?php

namespace App\Http\Controllers;


use App\Handlers\Admin\AuthHandler;
use App\Models\Usuario;

use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;

use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        $authHandler = new AuthHandler();
        $apiController = new APIController();
        //return $usuarios;
        $user = 1;
        $token = $authHandler->GenerateToken($user);

            $success = [
                'user' => $user,
                'token' => $token,
            ];
    
            return $apiController->sendResponse($success, 'user registered successfully', 201);
    }

    public function login(Request $request)
    {
        //$products= Usuario::all();
        //return $products;
        $json = Usuario::where('usuario', $request->usuario)->where('password', $request->password)->get();
        
        if($json->isEmpty())
		{
			$jsonResult = array(
				'cod_usuario' => false
			);
		}
        else
        {
            /*
            $jsonResult = array(
				"cod_usuario" => $json[0]["cod_usuario"]
			);
            */

            $authHandler = new AuthHandler();
            $apiController = new APIController();
            
            $token = $authHandler->GenerateToken($json[0]['cod_usuario']);

            $jsonResult = array(
                'usuario' => $json[0]['nombre'],
                'tipo_usuario' => $json[0]['tipo_usuario'],
                'token' => $token,
                'estado' => 1
            );
        
            //$jsonResult = $apiController->sendResponse($data, 'user registered successfully', 201);
            
        }
		
        return $jsonResult;
        /*
        $usuario = new Usuario();
        $usuario->usuario = $request->usuario;
        $usuario->password = $request->password;
        $authHandler = new AuthHandler();
        $apiController = new APIController();


        DB::table('incident_days')->where('cat_employee_incident_type_id', $request->incident_id)
        ->where('first_year_rank','<',$antiquity)
        ->where('second_year_rank','>',$antiquity)->first();

        $user = 1;
        $token = $authHandler->GenerateToken($user);

        $success = [
            'user' => $user,
            'token' => $token,
        ];
    
        return $apiController->sendResponse($success, 'user registered successfully', 201);

        */
        /*
        $row = $usuario->save();
		if($row==true)
		{
			$json = array(
					"estado" => 1,
					"descripcion" => "Registro almacenado correctamente"
			);
		}
		else
		{
			$json = array(
					"estado" => 0,
					"descripcion" => "Registro no se pudo almacenar correctamente"
			);
		}
		echo json_encode($json);
        */
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = new Usuario();
        $usuario->cod_usuario = $request->cod_usuario;
        $usuario->cedula = $request->cedula;
        $usuario->apellido = $request->apellido;
        $usuario->nombre = $request->nombre;
        $usuario->genero = $request->genero;
        $usuario->etnia = $request->etnia;
        $usuario->direccion = $request->direccion;
        $usuario->celular = $request->celular;
        $usuario->correo = $request->correo;
        $usuario->nivel_instruccion = $request->nivel_instruccion;
        $usuario->usuario = $request->usuario;
        $usuario->password = $request->password;
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->estado = 1;
        
        $row = $usuario->save();
		if($row==true)
		{
			$json = array(
					"estado" => 1,
					"descripcion" => "Registro almacenado correctamente"
			);
		}
		else
		{
			$json = array(
					"estado" => 0,
					"descripcion" => "Registro no se pudo almacenar correctamente"
			);
		}
		echo json_encode($json);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
