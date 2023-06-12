<?php
require_once './models/Mesa.php';
require_once './interfaces/ApiInterface.php';

class MesaController implements ApiInterface{

    public function TraerTodos($request, $response, $args){
        $array= Mesa::TraerMesas();

        $retorno= json_encode(array("Mesas " => $array));

        $response->getBody()->write($retorno);

        return $response;
    }
	public function CargarUno($request, $response, $args){

        $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        $mesa= new Mesa();
        $retorno;
        
        if($mesa->ComprobarCodigo($codigo)){
            $mesa->codigo= $codigo;
            $mesa->estado= "Libre";
            $mesa->CargarMesa();
            $retorno= json_encode(array('Mesa cargada' => $mesa->codigo));
        }
        else $retorno= json_encode(array("Mensaje"=>"Error, ya existe ese codigos"));


        $response->getBody()->write($retorno);

        return $response;
    }
}