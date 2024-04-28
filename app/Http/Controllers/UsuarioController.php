<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Handlers\Admin\AuthHandler;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PublicHelper;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::where('tipo_usuario', 'GESTOR')->where('estado', 1)->orderBy('cod_usuario','desc')->get()->makeHidden(['password']);
        return $usuarios;
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

    public function searchEmail($correo)
    {
        $json = Usuario::where('correo', $correo)->where('estado', 1)->get();
        
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
        $json = Usuario::where('cedula', $cedula)->where('estado', 1)->get();
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

    public function searchUser($usuario)
    {
        $json = Usuario::where('usuario', $usuario)->where('estado', 1)->get();
        
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
        $cod_usuario = $token->data->userID;

        $json = Usuario::where('cod_usuario', $cod_usuario)->get();
        
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

    public function show(string $id)
    {
        
    }

    public function save(Request $request)
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

    public function saveManager(Request $request)
    {
        $usuario = new Usuario();
        $usuario->cod_usuario = $request->cod_usuario;
        $usuario->apellido = $request->apellido;
        $usuario->nombre = $request->nombre;
        $usuario->celular = $request->celular;
        $usuario->correo = $request->correo;
        $usuario->usuario = $request->usuario;
        $hash = Usuario::hash($request->password);
        $usuario->password = $hash;
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->estado = 1;
        
        $row = $usuario->save();
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

    public function updateManager(Request $request)
    {
        $usuario  = Usuario::find($request->cod_usuario);
        $usuario->apellido = $request->apellido;
        $usuario->nombre = $request->nombre;
        $usuario->celular = $request->celular;
        $usuario->correo = $request->correo;
        $usuario->usuario = $request->usuario;
        $hash = Usuario::hash($request->password);
        $usuario->password = $hash;
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->estado = 1;
        
        $row = $usuario->save();
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

    public function destroyManager(Request $request)
    {
        $usuario  = Usuario::find($request->cod_usuario);
        $usuario->estado = 0;
        
        $row = $usuario->save();
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
