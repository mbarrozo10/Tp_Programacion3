<?php
require_once './models/Usuario.php';
require_once './interfaces/ApiInterface.php';

class UsuarioController extends Usuario implements ApiInterface
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
       
        $user = $parametros['usuario'];
        $clave = $parametros['clave'];
        $tipo = $parametros['tipo'];

        $usuario = new Usuario();
        $usuario->usuario= $user;
        $usuario->clave= $clave;
        $usuario->tipo= $tipo;

        $usuario->crearUsuario();

        $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
}
