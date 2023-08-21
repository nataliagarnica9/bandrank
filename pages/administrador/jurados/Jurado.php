<?php

class Jurado
{
    private $db;


    function __construct($db) {
        // Recibo la conexion de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    public function guardar($data, $files) {
        try {
            $nombre_imagen = "";

            if ($files['firma'] && $files['firma']['name'] != ''){
                $nombre_imagen = $files['firma']['name'];
                $archivo = '../../../dist/images/firmas/'.$nombre_imagen;
                move_uploaded_file( $files['firma']['tmp_name'], $archivo);
            }


            $query = $this->db->prepare("INSERT INTO jurado (documento_identificacion, nombres, apellidos, celular, correo, clave, fecha_registro,
                                         id_concurso, firma) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
            $query->bindValue(1, $data["documento_identificacion"]);
            $query->bindValue(2, $data["nombres"]);
            $query->bindValue(3, $data["apellidos"]);
            $query->bindValue(4, $data["celular"]);
            $query->bindValue(5, $data["correo"]);
            $query->bindValue(6, $data["clave"]);
            $query->bindValue(7, date("Y-m-d H:i:s"));
            $query->bindValue(8, $data["concurso"]);
            $query->bindValue(9, $nombre_imagen);
            $query->execute();

            $status = $query->errorInfo();

            // Valido que el código de mensaje sea válido para identificar que si se guardó el registro
            if($status[0] == 00000) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function response($params){

        $columns = array(
            0 => 'id',
            1 => 'nombre_completo',
            2 => 'documento_identificacion',
            3 => 'correo',
            4 => 'concurso',
        );

        $sql = 'SELECT
                    j.id,
                    CONCAT(j.nombres, " ", j.apellidos) AS nombre_completo,
                    j.documento_identificacion,
                    j.correo,
                    c.nombre_concurso
                FROM
                  jurado j
                INNER JOIN concurso c ON j.id_concurso = c.id_concurso  
                WHERE activo = 1';

        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = "  AND ( CONCAT(j.nombres, ' ', j.apellidos) LIKE '%" . $params['search']['value'] . "%'
             OR j.correo LIKE '%" . $params['search']['value'] . "%'
             OR c.nombre_concurso LIKE '%" . $params['search']['value'] . "%' )";
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

    public function getJuradoById($id) {
        $query = $this->db->prepare("SELECT * FROM jurado WHERE id = ?;");
        $query->bindValue(1, $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}