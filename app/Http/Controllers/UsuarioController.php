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

use App\Helpers\PublicHelper;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
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
        */
    }

    public function login(Request $request)
    {
        $hash = Usuario::hash($request->password);
        $json = Usuario::where('usuario', $request->usuario)->where('password', $hash)->get();
        
        if($json->isEmpty())
		{
			$jsonResult = array(
				'cod_usuario' => false
			);
		}
        else
        {
            $authHandler = new AuthHandler();
            $apiController = new APIController();
            
            $token = $authHandler->GenerateToken($json[0]['cod_usuario']);

            $jsonResult = array(
                'usuario' => $json[0]['nombre'],
                'tipo_usuario' => $json[0]['tipo_usuario'],
                'token' => $token,
                'estado' => 1
            ); 
        }
		
        return $jsonResult;
    }

    public function searchEmail($email)
    {
        $json = Usuario::where('correo', $email)->get();
        
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

    public function searchCedula($cedula)
    {
        $json = Usuario::where('cedula', $cedula)->get();
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

    public function searchUser($user)
    {
        $json = Usuario::where('usuario', $user)->get();
        
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

    public function searchRowUser(Request $request)
    {
        $publicHelper = new PublicHelper();
        $token = $publicHelper->GetAndDecodeJWT();
        $userID = $token->data->userID;

        $json = Usuario::where('cod_usuario', $userID)->get();
        
        if($json->isEmpty())
		{
			$jsonResult = array(
				'estado' => false
			);
		}
        else
        {
            $jsonResult = $json[0];
        }
		
        return $jsonResult;
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
        $hash = Usuario::hash($request->password);
        $usuario->password = $hash;
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
					"descripcion" => "Registro no se pudo almacenar"
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
    public function update(Request $request)
    {
        $usuario  = Usuario::find($request->cod_usuario);
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
        $hash = Usuario::hash($request->password);
        $usuario->password = $hash;
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->estado = 1;
        
        $row = $usuario->save();
		if($row==true)
		{
			$json = array(
					"estado" => 1,
					"descripcion" => "Registro actualizado correctamente"
			);
		}
		else
		{
			$json = array(
					"estado" => 0,
					"descripcion" => "Registro no se pudo actualizar"
			);
		}
		echo json_encode($json);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
