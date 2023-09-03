<?php

class Concurso {
    private $db;

    function __construct($db) {
        // Recibo la conexion de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    public function response($params){

        $columns = array(
            0 => 'id_concurso',
            1 => 'nombre_concurso',
            2 => 'ubicacion',
            3 => 'director',
        );

        $sql = 'SELECT
                    id_concurso,
                    nombre_concurso,
                    ubicacion,
                    director,
                    finalizado
                FROM
                  concurso
                WHERE eliminado = 0';

        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = "  AND ( nombre_concurso LIKE '%" . $params['search']['value'] . "%'
             OR ubicacion LIKE '%" . $params['search']['value'] . "%'
             OR director LIKE '%" . $params['search']['value'] . "%' )";
        }
        if (isset($whereSearch)) {
            $sql .= $whereSearch;
        }

        $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

        $query = $this->db->prepare($sql);
        $query->execute();
        $concursos=$query->fetchAll(PDO::FETCH_OBJ);

        //datos para renderizar
        $response['data'] = $concursos;
        $response['totalTableRows'] = count($concursos);
        $response['countRenderRows'] = count($concursos);
        return $response;
    }

    public function save($data) {
        try {
            $query = $this->db->prepare("INSERT INTO concurso (nombre_concurso, ubicacion, director, eliminado, id_categoria, fecha_evento) VALUES (?, ?, ?, ?, ?, ?);");
            $query->bindValue(1, $data["nombre_concurso"]);
            $query->bindValue(2, $data["ubicacion"]);
            $query->bindValue(3, $data["director"]);
            $query->bindValue(4, '0');
            $query->bindValue(5, $data["categoria"]);
            $query->bindValue(6, $data["fecha_evento"]);
            $query->execute();

            $status = $query->errorInfo();

            // Valido que el código de mensaje sea válido para identificar que si se guardó el registro
            if($status[0] == '00000') {
                return true;
            } else {
                return false;
            }

        } catch (Exception $ex) {
            return $ex;
        }
    }


    ///////////

    public function actualizar($data)
{
    try {
        $query = $this->db->prepare("UPDATE concurso SET nombre_concurso = ?, ubicacion = ?, director = ?, id_categoria = ?, fecha_evento = ? WHERE id_concurso = ?");
        $query->bindValue(1, $data["nombre_concurso"]);
        $query->bindValue(2, $data["ubicacion"]);
        $query->bindValue(3, $data["director"]);
        $query->bindValue(4, $data["id_categoria"]);
        $query->bindValue(5, $data["fecha_evento"]);
        $query->bindValue(6, $data["id_concurso"]);
        $query->execute();

        $status = $query->errorInfo();

        // Valido que el código de mensaje sea válido para identificar si se guardó el registro correctamente
        if ($status[0] === '00000') {
            return true;
        } else {
            return false;
        }

    } catch (Exception $ex) {
        return $ex;
    }
}

public function getConcursoById($id) {
    $query = $this->db->prepare("SELECT c.*, cc.nombre_categoria AS nombre_categoria_concurso
                                 FROM concurso c
                                 INNER JOIN categorias_concurso cc ON c.id_categoria = cc.id_categoria
                                 WHERE c.id_concurso = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetch(PDO::FETCH_OBJ);
}

//Eliminaciones////////////////////////////////////////////////////////////////////////////
public function eliminarConcurso($id_concurso)
{
    try {
        $stmt = $this->db->prepare("UPDATE concurso SET eliminado = 1 WHERE id_concurso = ?");
        $stmt->execute([$id_concurso]);
    
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

public function verConcursosEliminados($params)
{
    $columns = array(
        0 => "id_concurso",
        1 => 'nombre_concurso',
        2 => 'ubicacion',
        3 => 'director',
    );

    $sql = 'SELECT c.id_concurso, c.nombre_concurso, c.ubicacion, c.director
            FROM concurso c
            WHERE c.eliminado = 1';

    if (isset($params['search']['value']) && $params['search']['value'] != '') {
        $whereSearch = " AND (c.nombre_concurso LIKE '%" . $params['search']['value'] . "%'
         OR c.ubicacion LIKE '%" . $params['search']['value'] . "%'
         OR c.director LIKE '%" . $params['search']['value'] . "%' )";
    }
    if (isset($whereSearch)) {
        $sql .= $whereSearch;
    }

    $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

    $query = $this->db->prepare($sql);
    $query->execute();
    $concursos = $query->fetchAll(PDO::FETCH_OBJ);

    $response['data'] = $concursos;
    $response['totalTableRows'] = count($concursos);
    $response['countRenderRows'] = count($concursos);
    return $response;
}

public function restaurarConcurso($id_concurso)
{
    try {
        $stmt = $this->db->prepare("UPDATE concurso SET eliminado = 0 WHERE id_concurso = ?");
        $stmt->execute([$id_concurso]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

public function eliminarConcursoDefinitivamente($id_concurso)
{
    try {
        $stmt = $this->db->prepare("DELETE FROM concurso WHERE id_concurso = ?");
        $stmt->execute([$id_concurso]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}


    
}