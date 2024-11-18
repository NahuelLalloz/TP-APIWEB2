<?php
require_once '../api/app/controllers/equipocontroller.php';
require_once '../api/app/models/equipomodel.php';
require_once '../api/app/controllers/logincontroller.php';
require_once '../api/app/libs/Router.php';
require_once '../api/app/helpers/api.helper.php';
require_once '../api/app/models/config.php';
require_once '../api/app/controllers/jugadorescontroller.php';
$router = new Router();



////////////EQUIPOS/////////////////

$router->addRoute('equipos/ranking/:RANKING', 'GET', 'EquipoController', 'getEquipoByRanking');
$router->addRoute('equipo', 'GET', 'EquipoController', 'getEquipos');
$router->addRoute('equipos/:ID', 'GET', 'EquipoController', 'getEquipoById');
$router->addRoute('equipo', 'POST', 'EquipoController', 'insertEquipo');





////////////JUGADORES/////////////////

$router->addRoute('jugador',            'GET',   'JugadorController', 'getJugadores');
$router->addRoute('jugador/:id_jugador', 'GET',   'JugadorController', 'getJugadorById');
$router->addRoute('jugador/:id_jugador', 'DELETE', 'JugadorController', 'deleteJugador');
$router->addRoute('jugador',            'POST',  'JugadorController', 'createJugador');
$router->addRoute('jugador/:id_jugador', 'PUT',   'JugadorController', 'updateJugador');




////////////AUTORIZACION////////////               
$router->addRoute('auth/token', 'GET', 'UserApiController', 'getToken');

$action = 'equipo';
if (!empty($_GET['resource'])) {
    $action = $_GET['resource'];
}
$router->route($action, $_SERVER['REQUEST_METHOD']);
