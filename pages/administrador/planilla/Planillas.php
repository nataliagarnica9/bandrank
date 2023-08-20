<?php

class Planillas
{
    private $db;

    function __construct($db) {
        $this->db = $db;
    }

    public function guardar($data) {
        try {
            $nombre_planilla = $data["nombre_planilla"];
            $id_concurso = $data["id_concurso"];

            $query = $this->db->prepare("INSERT INTO planilla (nombre_planilla, eliminado, id_concurso) VALUES (?, 0, ?)");
            $query->bindValue(1, $nombre_planilla);
            $query->bindValue(2, $id_concurso);
            $query->execute();

            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    public function response($params) {
        $columns = array(
            0 => 'nombre_planilla',
            1 => 'nombre_concurso',
        );

        $sql = 'SELECT p.nombre_planilla, c.nombre_concurso
                FROM planilla p
                INNER JOIN concurso c ON p.id_concurso = c.id_concurso
                WHERE p.eliminado = 0';

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

    public function getDatosPlanilla($id_planilla) {
        $query = $this->db->prepare("SELECT * FROM planilla WHERE id_planilla = ?;");
        $query->bindValue(1, $id_planilla);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function eliminarPlanilla($id_planilla) {
        try {
            $stmt = $this->db->prepare("UPDATE planilla SET eliminado = 1 WHERE id_planilla = ?");
            $stmt->execute([$id_planilla]);

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
