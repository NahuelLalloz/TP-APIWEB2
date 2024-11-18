<?php
include_once '../api/app/models/equipomodel.php';
include_once '../api/app/helpers/api.helper.php';
include_once '../api/app/views/apiview.php';
include_once '../api/app/controllers/apicontroller.php';
include_once '../api/app/views/equipoview.php';
include_once '../api/app/libs/response.php';
include_once '../api/app/libs/request.php';
class EquipoController extends ApiController
{
    private $model;
    protected $view;
    private $authHelper;

    function __construct()
    {
        parent::__construct();
        $this->model = new EquipoModel();
        $this->view = new EquipoView();
        $this->authHelper = new AuthHelper();
    }

    //GET http://localhost:80/tpecsrestful/api/api/equipo
    function getEquipos($req, $res)
    {
        $equipo = $this->model->getEquipo();
        return $this->view->response($equipo, 200);
    }
    //GET http://localhost:80/tpecsrestful/api/api/equipos/[ID DESEADA]
    function getEquipoById($req, $res)
    {

        $params = $req->getParams();
        $id = $params['ID'] ?? null;

        if (!$id || !is_numeric($id)) {
            $res->send(['error' => 'ID inválido o no proporcionado'], 400);
            return;
        }

        $equipos = $this->model->getEquipoById($id);

        if (!empty($equipos)) {
            $res->send($equipos, 200);
        } else {
            $res->send(['error' => 'No existe un equipo con esa ID'], 404);
        }
    }
    /*

    INSERT http://localhost/tpecsrestful/api/api/equipo/
     {
        "nombre_equipo": "EquipoDePrueba",
        "ranking": "[ranking del equipo]",
        "region": "[Region del equipo]"
    }
    */

    function insertEquipo($params = [])
    { { {

                $user = $this->authHelper->currentUser();
                if (!$user) {
                    $this->view->response('Unauthorized', 401);
                    return;
                }
            }
        }
        $body = $this->getData();

        $nombre_equipo = $body->nombre_equipo;
        $ranking = $body->ranking;
        $region = $body->region;


        $id = $this->model->insertEquipo($nombre_equipo, $ranking, $region);

        if ($id === false) {
            $this->view->response('Error al insertar el equipo en la base de datos.', 500);
            return;
        }

        $this->view->response([
            'message' => 'Equipo ingresado correctamente',
            'id' => $id
        ], 201);
    }


    //http://localhost/tpecsrestful/api/api/equipos/[RANKING DESEADO]

    public function getEquipoByRanking($request, $response)
    {

        $params = $request->getParams();
        $ranking = $params['RANKING'] ?? null;

        if ($ranking) {

            $equipos = $this->model->getEquipoByRanking($ranking);

            if ($equipos) {
                $response->send($equipos, 200);
            } else {
                $response->send(['error' => "No se encontraron equipos con el ranking $ranking"], 404);
            }
        } else {
            $response->send(['error' => 'Falta el parámetro de ranking'], 400);
        }
    }
}
