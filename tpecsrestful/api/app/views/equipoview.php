<?php

class EquipoView
{
    public function showEquipos($equipo)
    {
        $count = count($equipo);
        require 'app/templates/inicio.phtml';
    }

    public function showEquiposDetalles($equipo)
    {

        require 'app/templates/equipoDetalle.phtml';
    }

    public function showError($msg)
    {
        echo "<h1>Error</h1>";
        echo "<h2>$msg</h2>";
    }

    public function showHomeLocation()
    {
        header("Location: " . BASE_URL . "home");
        exit();
    }

    public function showErrorDuplicado($message)
    {
        $errorMsg = $message;
        require 'app/templates/error22.phtml';
    }

    public function response($data, $status)
    {

        http_response_code($status);


        header('Content-Type: application/json');


        echo json_encode($data);
        exit();
    }
    public function showAgregarJugador($equipo)
    {
        require 'app/templates/agregarJugador.phtml';
    }
}
