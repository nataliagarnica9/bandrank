<?php

class Banda
{
    private $db;


    function __construct($db) {
        // Recibo la conexion de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    public function guardar($data) {
        try {
            $query = $this->db->prepare("INSERT INTO banda (nombre, ubicacion, nombre_instructor, correo_instructor,categoria,id_concurso) VALUES (?, ?, ?, ?, ?, ?);");
            $query->bindValue(1, $data["nombre"]);
            $query->bindValue(2, $data["ubicacion"]);
            $query->bindValue(3, $data["nombre_instructor"]);
            $query->bindValue(4, $data["correo_instructor"]);
            $query->bindValue(5, $data["categoria"]);
            $query->bindValue(6, $data["id_concurso"]);
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
}