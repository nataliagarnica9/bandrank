<?php

class Banda
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

            $query = $this->db->prepare("INSERT INTO banda (nombre, ubicacion, nombre_instructor, correo_instructor,id_categoria,id_concurso,clave, firma) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
            $query->bindValue(1, $data["nombre"]);
            $query->bindValue(2, $data["ubicacion"]);
            $query->bindValue(3, $data["nombre_instructor"]);
            $query->bindValue(4, $data["correo_instructor"]);
            $query->bindValue(5, $data["id_categoria"]);
            $query->bindValue(6, $data["id_concurso"]);
            $query->bindValue(7, $data["clave"]);
            $query->bindValue(8, $nombre_imagen);
            $query->execute();

            $status = $query->errorInfo();

            $ultimo_id = $this->db->lastInsertId();

            $query_login = $this->db->prepare("INSERT INTO login (correo, clave, tipo_usuario, id_registro) VALUES (?, ?, ?, ?);");
            $query_login->bindValue(1, $data["correo_instructor"]);
            $query_login->bindValue(2, $data["clave"]);
            $query_login->bindValue(3, 'instructor');
            $query_login->bindValue(4, $ultimo_id);
            $query_login->execute();

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

        // Función para obtener las penalizaciones y responder a las solicitudes AJAX
    public function response($params)
    {
        // Defino las columnas para el ordenamiento y la búsqueda
        $columns = array(
            0 => "id_banda",
            1 => "nombre",
            2 => 'ubicacion',
            3 => 'nombre_instructor',
        );

        // Preparo la consulta SQL para obtener las penalizaciones
        $sql = 'SELECT id_banda, nombre, ubicacion, nombre_instructor
                FROM banda';

        // Agrego condiciones de búsqueda si se proporciona un valor de búsqueda
        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = " WHERE (nombre LIKE '%" . $params['search']['value'] . "%'
             OR ubicacion LIKE '%" . $params['search']['value'] . "%'
             OR nombre_instructor LIKE '%" . $params['search']['value'] . "%' )";
        }
        if (isset($whereSearch)) {
            $sql .= $whereSearch;
        }

        // Agrego el ordenamiento y la paginación a la consulta
        $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

        // Ejecuto la consulta y obtengo las penalizaciones
        $query = $this->db->prepare($sql);
        $query->execute();
        $banda = $query->fetchAll(PDO::FETCH_OBJ);

        // Preparo los datos para enviar como respuesta JSON
        $response['data'] = $banda;
        $response['totalTableRows'] = count($banda);
        $response['countRenderRows'] = count($banda);
        return $response;
    }

    
    public function eliminarBanda($id_banda)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM banda WHERE id_banda = ?");
            $stmt->bindValue(1, $id_banda);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }



public function actualizar($data) {
        try {
            $query = $this->db->prepare("UPDATE banda SET nombre = ?, ubicacion = ?, nombre_instructor = ?, id_categoria = ?, correo_instructor = ?, id_concurso = ? WHERE id_banda = ?");
            $query->bindValue(1, $data["nombre"]);
            $query->bindValue(2, $data["ubicacion"]);
            $query->bindValue(3, $data["nombre_instructor"]);
            $query->bindValue(4, $data["id_categoria"]);
            $query->bindValue(5, $data["correo_instructor"]);
            $query->bindValue(6, $data["id_concurso"]);
            $query->bindValue(7, $data["id_banda"]);
            $query->execute();

            $query_login = $this->db->prepare("UPDATE login SET correo = ? WHERE id_registro = ?");
                $query_login->bindValue(1, $data["correo"]);
                $query_login->bindValue(2, $data["id_banda"]);
                $query_login->execute();
    
            $status = $query->errorInfo();

            if($data["clave"] != '') {
                $query_clave = $this->db->prepare("UPDATE banda SET clave = ? WHERE id_banda = ?");
                $query_clave->bindValue(1, $data["clave"]);
                $query_clave->bindValue(2, $data["id_banda"]);
                $query_clave->execute();

                $query_login1 = $this->db->prepare("UPDATE login SET clave = ? WHERE id_registro = ?");
                $query_login1->bindValue(1, $data["clave"]);
                $query_login1->bindValue(2, $data["id_banda"]);
                $query_login1->execute();
            }
    
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

    public function getBandaById($id) {
        $query = $this->db->prepare("SELECT * FROM banda WHERE id_banda = ?;");
        $query->bindValue(1, $id);
        $query->execute();
    
        return $query->fetch(PDO::FETCH_OBJ);
    }
}