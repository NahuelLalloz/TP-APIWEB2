<?php

class JugadorView
{
    public function showJugadores($jugadores, $equipos)
    {
        $count = count($jugadores);

        require 'app/templates/jugador.phtml';
    }

    public function viewJugador($jugador)
    {

        require 'app/templates/jugadorDetalle.phtml';
    }
    function ShowHomeLocation()
    {
        header("Location: " . BASE_URL . "home");
    }
    function showError($msg)
    {
        echo "<h1>Error</h1>";
        echo "<h2>$msg</h2>";
    }
    public function showJugadoresByEquipo($jugadores, $error = null)
    {

        require './templates/jugadores/agregarJugador.phtml';
    }
}
