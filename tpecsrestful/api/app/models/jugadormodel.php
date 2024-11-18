<?php
require_once 'app/models/config.php';
class JugadorModel
{

    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=cstpe;charset=' . DB_Charset, DB_USER, DB_PASS);
    }
    function getJugadores($fk_equipo = null, $orderBy = null, $order = null, $limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM jugadores';
        $params = [];


        if ($fk_equipo) {
            $sql .= ' WHERE fk_equipo = :fk_equipo';
            $params[':fk_equipo'] = $fk_equipo;
        }

        if ($orderBy) {
            $validColumns = ['nombre_jugador', 'kd', 'id_jugador', 'posicion', 'fk_equipo'];
            if (in_array($orderBy, $validColumns)) {
                $sql .= ' ORDER BY ' . $orderBy;
                $sql .= ($order === 'desc') ? ' DESC' : ' ASC';
            } else {
                throw new Exception("Campo de ordenamiento no válido: " . $orderBy);
            }
        }


        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }


        error_log("SQL: " . $sql);
        error_log("Params: " . json_encode($params));


        $query = $this->db->prepare($sql);


        foreach ($params as $key => $value) {
            $query->bindValue($key, $value);
        }

        if ($limit !== null && $offset !== null) {
            $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getJugadorById($id_jugador)
    {
        $query = $this->db->prepare('SELECT * FROM jugadores WHERE id_jugador=?');
        $query->execute([$id_jugador]);
        $jugador = $query->fetch(PDO::FETCH_OBJ);
        return $jugador;
    }
    function deleteJugador($id_jugador)
    {
        $query = $this->db->prepare('DELETE FROM jugadores WHERE id_jugador = ?');
        $query->execute([$id_jugador]);
    }

    function insertJugador($nombre_jugador, $posicion, $kd, $fk_equipo)
    {
        $query = $this->db->prepare('INSERT INTO jugadores(nombre_jugador, posicion, kd, fk_equipo) VALUES ( ?, ?, ?, ?)');
        $query->execute([$nombre_jugador, $posicion, $kd, $fk_equipo]);
        return $this->db->lastInsertId();
    }
    function updateJugador($id_jugador, $nombre_jugador, $posicion, $kd, $fk_equipo)
    {
        $query = $this->db->prepare('UPDATE jugadores SET nombre_jugador=?, posicion=?, kd=?, fk_equipo=?  WHERE id_jugador = ?');
        $query->execute([$nombre_jugador, $posicion, $kd, $fk_equipo, $id_jugador]);
    }
    public function finalize($id_jugador)
    {
        $query = $this->db->prepare('UPDATE jugadores SET finalizada = 1 WHERE id_jugador = ?');
        $query->execute([$id_jugador]);
    }

    public function existsJugador($nombre_jugador)
    {
        $query = $this->db->prepare('SELECT COUNT(*) FROM jugadores WHERE nombre_jugador = ?');
        $query->execute([$nombre_jugador]);


        return $query->fetchColumn() > 0;
    }
}
