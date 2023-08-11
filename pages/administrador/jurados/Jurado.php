<?php

class Jurado
{
    private $db;


    function __construct($db) {
        // Recibo la conexion de base de datos y la establezco globalmente en el modelo
        $this->db = $db;
    }

    public function guardar($data) {
        try {
            $query = $this->db->prepare("INSERT INTO jurado (documento_identificacion, nombres, apellidos, celular, correo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?);");
            $query->bindValue(1, $data["documento_identificacion"]);
            $query->bindValue(2, $data["nombres"]);
            $query->bindValue(3, $data["apellidos"]);
            $query->bindValue(4, $data["celular"]);
            $query->bindValue(5, $data["correo"]);
            $query->bindValue(6, date("Y-m-d H:i:s"));
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