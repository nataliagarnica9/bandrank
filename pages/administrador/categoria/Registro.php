<?php

class Registro
{
    private $db;


    function __construct($db) {
        // Recibo la conexion de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    public function guardar($data) {
        try {
            $query = $this->db->prepare("INSERT INTO categorias_concurso (nombre_categoria) VALUES (?);");
            $query->bindValue(1, $data["nombre_categoria"]);
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

    public function response($params)
    {
        $columns = array(
            0 => 'id_categoria',
            1 => 'nombre_categoria',
        );

        $sql = 'SELECT
                    id_categoria,
                    nombre_categoria
                FROM
                  categorias_concurso
                WHERE eliminado = 0 ';

        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = "  AND ( nombre_categoria LIKE '%" . $params['search']['value'] . "%' )";
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

    public function eliminar($id)
    {
        try {
            $stmt = $this->db->prepare("UPDATE concurso SET eliminado = 1 WHERE id_concurso = ?");
            $stmt->execute([$id]);

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}