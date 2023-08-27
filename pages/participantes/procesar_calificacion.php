<?php
include("../../config.php");
error_reporting(E_ALL);
        try {
            $query = $db->prepare("INSERT INTO encabezado_calificacion (id_jurado, id_concurso, id_planilla, total_calificacion, observaciones) VALUES (?, ?, ?, ?, ?);");
            $query->bindValue(1, $_SESSION["ID_USUARIO"]);
            $query->bindValue(2, $_POST["id_concurso"]);
            $query->bindValue(3, $_POST["id_planilla"]);
            $query->bindValue(4, $_POST["total_calificacion"]);
            $query->bindValue(5, $_POST["observaciones"]);
            $query->execute();

            $query = $db->prepare("INSERT INTO detalle_calificacion (id_calificacion, id_criterioevaluacion, puntaje) VALUES (?, ?, ?);");
            $query->bindValue(1, $_POST["id_calificacion"]);
            $query->bindValue(2, $_POST["id_criterioevaluacion"]);
            $query->bindValue(3, $_POST["puntaje"]);
            $query->execute();
        } catch (Exception $ex) {
            return $ex;
        }
?>