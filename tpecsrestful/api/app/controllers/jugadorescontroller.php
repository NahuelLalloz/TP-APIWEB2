<?php
include_once '../api/app/libs/response.php';
include_once '../api/app/views/apiview.php';
include_once '../api/app/helpers/api.helper.php';
include_once '../api/app/controllers/apicontroller.php';
include_once '../api/app/models/jugadormodel.php';
include_once '../api/app/libs/response.php';
include_once '../api/app/libs/request.php';
include_once 'app/views/jugadorview.php';
class JugadorController extends ApiController
{
    protected $view;
    private $model;
    private $modele;
    private $authHelper;

    function __construct()
    {
        parent::__construct();
        $this->model = new JugadorModel();
        $this->modele = new EquipoModel();
        $this->view = new APIView();
        $this->authHelper = new AuthHelper();
    }


    function getJugadores($req, $res)
    {



        $fk_equipo = null;
        if (isset($req->query->fk_equipo))
            $fk_equipo = $req->query->fk_equipo;

        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }
        $order = false;
        if (isset($req->query->order)) {
            $order = $req->query->order;
            if ($order != 'asc' && $order != 'desc') {
                return $this->view->response("No se puede ordenar de esa forma, ingrese asc o desc", 400);
            }
        }

        $jugadores = $this->model->getJugadores($fk_equipo, $orderBy, $order);




        // Paginación http://localhost:80/tpecsrestful/api/api/jugador?show=x&page=x
        $show = isset($_GET['show']) ? (int)$_GET['show'] : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : null;

        if ($show && $page) {
            if ($show <= 0 || $page <= 0) {
                return $this->view->response("Los parámetros 'show' y 'page' deben ser mayores a 0.", 400);
            }

            $offset = ($page - 1) * $show;
            $jugadores = $this->model->getJugadores($fk_equipo, $orderBy, $order, $show, $offset);

            $totalJugadores = count($this->model->getJugadores($fk_equipo));
            $totalPages = ceil($totalJugadores / $show);

            return $this->view->response($jugadores, 200);
        }

        // Sin paginación
        $jugadores = $this->model->getJugadores($fk_equipo, $orderBy, $order);
        return $this->view->response($jugadores, 200);
    }
    public function getJugadorById($req, $res)
    {

        $params = $req->getParams();
        $id_jugador = $params['id_jugador'] ?? null;


        if (!$id_jugador || !is_numeric($id_jugador)) {
            $res->send(['error' => 'ID de jugador inválido o no proporcionado'], 400);
            return;
        }


        $jugador = $this->model->getJugadorById($id_jugador);

        if ($jugador) {
            $res->send($jugador, 200);
        } else {
            $res->send(['error' => 'No existe un jugador con esa ID'], 404);
        }
    }

    function deleteJugador($req, $res)
    {
        $id_jugador = $req->params->id_jugador;
        $jugador = $this->model->getJugadorById($id_jugador);
        if (!$jugador) {
            return $this->view->response('el jugador que desea eleminar no existe', 404);
        }

        $this->model->deleteJugador($id_jugador);
        $this->view->response("el jugador se elemino con exito", 200);
    }
    function createJugador($req, $res)
    {
        $newjugador = $req->body;

        if (empty($newjugador->nombre_jugador) || empty($newjugador->posicion) || empty($newjugador->kd) || empty($newjugador->fk_equipo)) {
            return $this->view->response("falta completar datos ", 400);
        }

        $id_jugador = $this->model->insertJugador($newjugador->nombre_jugador, $newjugador->posicion, $newjugador->kd, $newjugador->fk_equipo);

        if ($id_jugador) {
            return $this->view->response("la tarea se creo con el id:$id_jugador", 201);
        } else {
            return $this->view->response("error al insertar tarea", 500);
        }
    }

    /*
{
    "nombre_jugador": "NOMBRE",
    "posicion": "x",
    "kd":"x",
    "fk_equipo":"[ID DEL EQUIPO DESEADO]"
}
*/



    function updateJugador($req, $res)
    { { { {

                    $user = $this->authHelper->currentUser();
                    if (!$user) {
                        $this->view->response('Unauthorized', 401);
                        return;
                    }
                }
            }
            $params = $req->getParams();
            $id_jugador = $params['id_jugador'] ?? null;

            if (!$id_jugador || !is_numeric($id_jugador)) {
                return $this->view->response("ID de jugador inválido", 400);
            }

            $jugador = $this->model->getJugadorById($id_jugador);
            if (!$jugador) {
                return $this->view->response('El jugador no existe', 404);
            }

            $body = json_decode(file_get_contents('php://input'), true);


            if (empty($body['nombre_jugador']) || empty($body['posicion']) || empty($body['kd']) || empty($body['fk_equipo'])) {
                return $this->view->response("Falta completar datos", 400);
            }


            $fk_equipo = $body['fk_equipo'];
            $equipo = $this->modele->getEquipoById($fk_equipo);

            if (!$equipo) {
                return $this->view->response("El equipo con ID $fk_equipo no existe", 404);
            }


            $nombre_jugador = $body['nombre_jugador'];
            $posicion = $body['posicion'];
            $kd = $body['kd'];


            $this->model->updateJugador($id_jugador, $nombre_jugador, $posicion, $kd, $fk_equipo);

            $jugador = $this->model->getJugadorById($id_jugador);

            return $this->view->response($jugador, 200);
        }
    }
}
