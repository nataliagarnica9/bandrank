<?php

class Planillas
{
    private $db;

    function __construct($db)
    {
        // Recibo la conexión de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    public function guardar($data)
    {
        try {
            $nombre_planilla = $data["nombre_planilla"];
            $id_concurso = $data["id_concurso"];

            $query = $this->db->prepare("INSERT INTO planilla (nombre_planilla, id_concurso, eliminado) VALUES (?, ?, 0)");
            $query->bindValue(1, $nombre_planilla);
            $query->bindValue(2, $id_concurso);
            $query->execute();

            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    public function response($params)
    {
        $columns = array(
            0 => "id_planilla",
            1 => 'nombre_planilla',
            2 => 'nombre_concurso',
        );

        $sqlTot = '';
        $sqlRec = '';

        $sql = 'SELECT p.id_planilla, p.nombre_planilla, c.nombre_concurso
                FROM planilla p
                INNER JOIN concurso c ON p.id_concurso = c.id_concurso
                WHERE p.eliminado = 0';

        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = " AND (p.nombre_planilla LIKE '%" . $params['search']['value'] . "%'
             OR c.nombre_concurso LIKE '%" . $params['search']['value'] . "%' )";
        }
        if (isset($whereSearch)) {
            $sqlTot .= $sql . $whereSearch;
            $sqlRec .= $sql . $whereSearch;
        } else {
            $sqlTot .= $sql;
            $sqlRec .= $sql;
        }

        $sqlRec .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

        $query = $this->db->prepare($sqlRec);
        $query->execute();
        $planillas = $query->fetchAll(PDO::FETCH_OBJ);

        $queryTot = $this->db->prepare($sqlTot);
        $queryTot->execute();
        $planillasTot = $queryTot->fetchAll(PDO::FETCH_OBJ);

        $response['data'] = $planillas;
        $response['totalTableRows'] = count($planillasTot);
        $response['countRenderRows'] = count($planillas);
        return $response;
    }
    public function eliminarPlanilla($id_planilla)
    {
        try {
            $stmt = $this->db->prepare("UPDATE planilla SET eliminado = 1 WHERE id_planilla = ?");
            $stmt->execute([$id_planilla]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function verPlanillasEliminadas($params)
    {
        $columns = array(
            0 => "id_planilla",
            1 => 'nombre_planilla',
            2 => 'nombre_concurso',
        );

        $sql = 'SELECT p.id_planilla, p.nombre_planilla, c.nombre_concurso
                FROM planilla p
                INNER JOIN concurso c ON p.id_concurso = c.id_concurso
                WHERE p.eliminado = 1';

        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = " AND (p.nombre_planilla LIKE '%" . $params['search']['value'] . "%'
             OR c.nombre_concurso LIKE '%" . $params['search']['value'] . "%' )";
        }
        if (isset($whereSearch)) {
            $sql .= $whereSearch;
        }

        $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

        $query = $this->db->prepare($sql);
        $query->execute();
        $planillas = $query->fetchAll(PDO::FETCH_OBJ);

        $response['data'] = $planillas;
        $response['totalTableRows'] = count($planillas);
        $response['countRenderRows'] = count($planillas);
        return $response;
    }

    public function restaurarPlanilla($id_planilla)
    {
        try {
            $stmt = $this->db->prepare("UPDATE planilla SET eliminado = 0 WHERE id_planilla = ?");
            $stmt->execute([$id_planilla]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function eliminarPlanillaDefinitivamente($id_planilla)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM planilla WHERE id_planilla = ?");
            $stmt->execute([$id_planilla]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerListaConcursos()
{
    try {
        $sql = "SELECT id_concurso, nombre_concurso FROM concursos";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return array();
    }
}

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
public function actualizar($data) {
    try {
        $query = $this->db->prepare("UPDATE planilla SET nombre_planilla = ?, id_concurso = ? WHERE id_planilla = ?");
        $query->bindValue(1, $data["nombre_planilla"]);
        $query->bindValue(2, $data["id_concurso"]);
        $query->bindValue(3, $data["id_planilla"]);
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


public function getPlanillaById($id) {
    $query = $this->db->prepare("SELECT p.*, p.nombre_planilla
                                 FROM planilla p
                                INNER JOIN concurso c on p.id_concurso = c.id_concurso
                                 WHERE p.id_planilla = ?;");
    $query->bindValue(1, $id);
    $query->execute();

    return $query->fetch(PDO::FETCH_OBJ);
    }


}
