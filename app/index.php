<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$app = AppFactory::create();

$app->setBasePath('/Tp_Programacion3/app');
$app->addErrorMiddleware(true, true, true);

$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
   
   // $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno');
  });

// $app->get('[/]', function (Request $request, Response $response) {    
//     $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
    
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });
$app->group('/productos', function (RouteCollectorProxy $group){
  $group->get('[/]', \ProductoController::class . ':TraerTodos');
 // $group->get('/{producto}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno');
});

$app->group('/mesa', function (RouteCollectorProxy $group){
  $group->get('[/]', \MesaController::class . ':TraerTodos');
  $group->post('[/]', \MesaController::class . ':CargarUno');
});

$app->group('/pedido', function (RouteCollectorProxy $group){
  $group->post('[/]', \PedidoController::class . ':CargarUno');
  $group->get('/{codigoPedido}/{codigoMesa}', \PedidoController::class . ':TraerFiltrado');
  $group->get('/{id}', \PedidoController::class . ':TraerFiltrado');
  $group->get('[/]', \PedidoController::class . ':TraerTodos');
});

$app->group('/modificarPedido', function (RouteCollectorProxy $group){
  $group->post('[id]', \PedidoController::class . ':AtenderPedido');
});

$app->run();
