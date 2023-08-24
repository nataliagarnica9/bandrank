<?php

class Criterios
{
    private $db;

    function __construct($db) {
        // Recibo la conexión de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    public function guardar($data) {
    try {
        $nombre_criterio = $data["nombre_criterio"];
        $rango_calificacion = $data["rango_calificacion"];
        $id_planilla = $data["id_planilla"];
        
        $query = $this->db->prepare("INSERT INTO criterio (nombre_criterio, rango_calificacion, id_planilla, eliminado) VALUES (?, ?, ?, 0)");
        $query->bindValue(1, $nombre_criterio);
        $query->bindValue(2, $rango_calificacion);
        $query->bindValue(3, $id_planilla);
        $query->execute();
        
        return true;
    } catch (PDOException $ex) {
        return false;
    }
}


    public function response($params)
{
    $columns = array(
        0 => "id_criterio",
        1 => 'nombre_criterio',
        2 => 'rango_calificacion',
        3 => 'nombre_planilla',
    );

    $sql = 'SELECT c.id_criterio, c.nombre_criterio, c.rango_calificacion, p.nombre_planilla
            FROM criterio c
            INNER JOIN planilla p ON c.id_planilla = p.id_planilla
            WHERE c.eliminado = 0'; // Agregar esta condición

    if (isset($params['search']['value']) && $params['search']['value'] != '') {
        $whereSearch = " AND (c.nombre_criterio LIKE '%" . $params['search']['value'] . "%'
         OR c.rango_calificacion LIKE '%" . $params['search']['value'] . "%'
         OR p.nombre_planilla LIKE '%" . $params['search']['value'] . "%' )";
    }
    if (isset($whereSearch)) {
        $sql .= $whereSearch;
    }

    $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

    $query = $this->db->prepare($sql);
    $query->execute();
    $criterios = $query->fetchAll(PDO::FETCH_OBJ);

    // Datos para renderizar
    $response['data'] = $criterios;
    $response['totalTableRows'] = count($criterios);
    $response['countRenderRows'] = count($criterios);
    return $response;
}


    public function getDatosCriterio($id_criterio) {
        $query = $this->db->prepare("SELECT * FROM criterio WHERE id_criterio = ?;");
        $query->bindValue(1, $id_criterio);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function eliminarCriterio($id_criterio)
{
    try {
        $stmt = $this->db->prepare("UPDATE criterio SET eliminado = 1 WHERE id_criterio = ?");
        $stmt->execute([$id_criterio]);
    
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
        
}
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
public function verCriteriosEliminados($params)
{
    $columns = array(
        0 => "id_criterio",
        1 => 'nombre_criterio',
        2 => 'rango_calificacion',
        3 => 'nombre_planilla',
    );

    $sql = 'SELECT c.id_criterio, c.nombre_criterio, c.rango_calificacion, p.nombre_planilla
            FROM criterio c
            INNER JOIN planilla p ON c.id_planilla = p.id_planilla
            WHERE c.eliminado = 1';

    if (isset($params['search']['value']) && $params['search']['value'] != '') {
        $whereSearch = " AND (c.nombre_criterio LIKE '%" . $params['search']['value'] . "%'
         OR c.rango_calificacion LIKE '%" . $params['search']['value'] . "%'
         OR p.nombre_planilla LIKE '%" . $params['search']['value'] . "%' )";
    }
    if (isset($whereSearch)) {
        $sql .= $whereSearch;
    }

    $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

    $query = $this->db->prepare($sql);
    $query->execute();
    $criterios = $query->fetchAll(PDO::FETCH_OBJ);

    $response['data'] = $criterios;
    $response['totalTableRows'] = count($criterios);
    $response['countRenderRows'] = count($criterios);
    return $response;
}

public function restaurarCriterio($id_criterio)
{
    try {
        $stmt = $this->db->prepare("UPDATE criterio SET eliminado = 0 WHERE id_criterio = ?");
        $stmt->execute([$id_criterio]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

public function eliminarCriterioDefinitivamente($id_criterio)
{
    try {
        $stmt = $this->db->prepare("DELETE FROM criterio WHERE id_criterio = ?");
        $stmt->execute([$id_criterio]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}


public function actualizar($data) {
    try {
        $query = $this->db->prepare("UPDATE criterio SET nombre_criterio = ?, rango_calificacion = ?, id_planilla = ? WHERE id_criterio = ?");
        $query->bindValue(1, $data["nombre_criterio"]);
        $query->bindValue(2, $data["rango_calificacion"]);
        $query->bindValue(3, $data["id_planilla"]);
        $query->bindValue(4, $data["id_criterio"]);
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


public function getCriterioById($id) {
    $query = $this->db->prepare("SELECT c.*, p.nombre_planilla
                                 FROM criterio c
                                 INNER JOIN planilla p ON c.id_planilla = p.id_planilla
                                 WHERE c.id_criterio = ?");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetch(PDO::FETCH_OBJ);
} 

}
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>



