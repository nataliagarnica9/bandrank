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
                    director
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
}