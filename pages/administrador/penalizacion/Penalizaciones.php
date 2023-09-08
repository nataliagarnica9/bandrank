<?php
class Penalizaciones
{
    private $db;

    function __construct($db) {
        // Recibo la conexión de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    // Función para guardar una nueva penalización
    public function guardar($data) {
        try {
            // Obtengo los datos del formulario
            $descripcion_penalizacion = $data["descripcion_penalizacion"];
            $tipo_penalizacion = $data["tipo_penalizacion"];
            $puntaje_penalizacion = $data["puntaje_penalizacion"];
        
            // Preparo y ejecuto la consulta para insertar la nueva penalización
            $query = $this->db->prepare("INSERT INTO penalizacion (descripcion_penalizacion, tipo_penalizacion, puntaje_penalizacion, eliminado) VALUES (?, ?, ?, 0)");
            $query->bindValue(1, $descripcion_penalizacion);
            $query->bindValue(2, $tipo_penalizacion);
            $query->bindValue(3, $puntaje_penalizacion);
            $query->execute();
        
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    // Función para obtener las penalizaciones y responder a las solicitudes AJAX
    public function response($params)
    {
        // Defino las columnas para el ordenamiento y la búsqueda
        $columns = array(
            0 => "id_penalizacion",
            1 => 'descripcion_penalizacion',
            2 => 'tipo_penalizacion',
            3 => 'puntaje_penalizacion',
        );

        // Preparo la consulta SQL para obtener las penalizaciones
        $sql = 'SELECT p.id_penalizacion, p.descripcion_penalizacion, p.tipo_penalizacion, p.puntaje_penalizacion
                FROM penalizacion p
                WHERE p.eliminado = 0';

        // Agrego condiciones de búsqueda si se proporciona un valor de búsqueda
        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = " AND (p.descripcion_penalizacion LIKE '%" . $params['search']['value'] . "%'
             OR p.tipo_penalizacion LIKE '%" . $params['search']['value'] . "%'
             OR p.puntaje_penalizacion LIKE '%" . $params['search']['value'] . "%' )";
        }
        if (isset($whereSearch)) {
            $sql .= $whereSearch;
        }

        // Agrego el ordenamiento y la paginación a la consulta
        $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';

        // Ejecuto la consulta y obtengo las penalizaciones
        $query = $this->db->prepare($sql);
        $query->execute();
        $penalizaciones = $query->fetchAll(PDO::FETCH_OBJ);

        // Preparo los datos para enviar como respuesta JSON
        $response['data'] = $penalizaciones;
        $response['totalTableRows'] = count($penalizaciones);
        $response['countRenderRows'] = count($penalizaciones);
        return $response;
    }

    public function eliminarPenalizacion($id_penalizacion)
    {
        try {
            $stmt = $this->db->prepare("UPDATE penalizacion SET eliminado = 1 WHERE id_penalizacion = ?");
            $stmt->execute([$id_penalizacion]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function verPenalizacionesEliminadas($params)
    {
        $columns = array(
            0 => "id_penalizacion",
            1 => 'descripcion_penalizacion',
            2 => 'tipo_penalizacion',
            3 => 'puntaje_penalizacion'
        );
    
        $sql = 'SELECT p.id_penalizacion, p.descripcion_penalizacion, p.tipo_penalizacion, p.puntaje_penalizacion
                FROM penalizacion p
                WHERE p.eliminado = 1'; // Ajustar la tabla y campos según tu estructura
    
        if (isset($params['search']['value']) && $params['search']['value'] != '') {
            $whereSearch = " AND (p.descripcion_penalizacion LIKE '%" . $params['search']['value'] . "%'
             OR p.tipo_penalizacion LIKE '%" . $params['search']['value'] . "%' )";
        }
        if (isset($whereSearch)) {
            $sql .= $whereSearch;
        }
    
        $sql .= ' ORDER BY ' . $columns[$params['order'][0]['column']] . ' ' . $params['order'][0]['dir'] . ' LIMIT ' . $params["start"] . '  , ' . $params['length'] . '';
    
        $query = $this->db->prepare($sql);
        $query->execute();
        $penalizaciones = $query->fetchAll(PDO::FETCH_OBJ);
    
        $response['data'] = $penalizaciones;
        $response['totalTableRows'] = count($penalizaciones);
        $response['countRenderRows'] = count($penalizaciones);
        return $response;
    }
    
    public function restaurarPenalizacion($id_penalizacion)
    {
        try {
            $stmt = $this->db->prepare("UPDATE penalizacion SET eliminado = 0 WHERE id_penalizacion = ?");
            $stmt->execute([$id_penalizacion]);
    
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function eliminarPenalizacionDefinitivamente($id_penalizacion)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM penalizacion WHERE id_penalizacion = ?");
            $stmt->execute([$id_penalizacion]);
    
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function actualizar($data) {
        try {
            $query = $this->db->prepare("UPDATE penalizacion SET descripcion_penalizacion = ?, tipo_penalizacion = ?, puntaje_penalizacion = ? WHERE id_penalizacion = ?");
            $query->bindValue(1, $data["descripcion_penalizacion"]);
            $query->bindValue(2, $data["tipo_penalizacion"]);
            $query->bindValue(3, $data["puntaje_penalizacion"]);
            $query->bindValue(4, $data["id_penalizacion"]);
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
    
    public function getPenalizacionById($id) {
        $query = $this->db->prepare("SELECT * FROM penalizacion WHERE id_penalizacion = ?;");
        $query->bindValue(1, $id);
        $query->execute();
    
        return $query->fetch(PDO::FETCH_OBJ);
    
    }
    public function getPuntajePenalizacionById($id) {
        $query = $this->db->prepare("SELECT puntaje_penalizacion, tipo_penalizacion FROM penalizacion WHERE id_penalizacion = ?;");
        $query->bindValue(1, $id);
        $query->execute();
        $fetch = $query->fetch(PDO::FETCH_OBJ);

    
        return $fetch;

    }
}
?>
