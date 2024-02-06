<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ClienteController;
use Controllers\LibroController;
use Controllers\ListaController;
use Controllers\LoginController;
use MVC\Router;

$router = new Router();

//ROUTTING LOGIN
$router->get('/',[LoginController::class,'login']);
$router->POST('/',[LoginController::class,'login']);

$router->get('/crear/cuenta',[LoginController::class,'crear']);
$router->POST('/crear/cuenta',[LoginController::class,'crear']);
$router->get('/mensaje',[LoginController::class,'mensaje']);
$router->get('/confirmar-cuenta',[LoginController::class,'confirmar']);
$router->get('/olvide/password',[LoginController::class,'olvide']);
$router->POST('/olvide/password',[LoginController::class,'olvide']);
$router->get('/recuperar/password',[LoginController::class,'recuperar']);
$router->POST('/recuperar/password',[LoginController::class,'recuperar']);
$router->get('/crear/sesion',[LoginController::class,'logout']);


//ROUTTING CLIENTE

$router->get('/cliente/cuenta',[ClienteController::class,'index']);
$router->POST('/cliente/buscar',[ClienteController::class,'buscar']);
$router->get('/cuenta/actualizar',[ClienteController::class,'actualizar']);
$router->POST('/cuenta/actualizar',[ClienteController::class,'actualizar']);
$router->get('/cliente/buscar',[ClienteController::class,'buscar']);
$router->get('/cliente/buscar/match',[ClienteController::class,'resultadoMatch']);
$router->get('/cliente/buscar/titulo',[ClienteController::class,'resultadoTitulo']);




//ROUTTING LISTA

$router->get('/lista/ver',[ListaController::class,'ver']);
$router->get('/lista/crear',[ListaController::class,'crear']);
$router->POST('/lista/crear',[ListaController::class,'crear']);
$router->get('/lista/añadir',[ListaController::class,'añadir']);
$router->POST('/lista/añadir',[ListaController::class,'añadir']);
$router->get('/lista/libro/eliminar',[ListaController::class,'eliminarLibro']);
$router->get('/lista/busqueda/ver',[ListaController::class,'verBusqueda']);


//ROUTTING LIBROS
$router->get('/libros/ver',[LibroController::class,'index']);







// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();