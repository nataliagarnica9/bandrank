<?php
include("../../config.php");
        try {
            $query = $db->prepare("INSERT INTO encabezado_calificacion (id_jurado, id_concurso, id_planilla, total_calificacion, observaciones, id_banda) VALUES (?, ?, ?, ?, ?, ?);");
            $query->bindValue(1, $_SESSION["ID_USUARIO"]);
            $query->bindValue(2, $_POST["id_concurso"]);
            $query->bindValue(3, $_POST["id_planilla"]);
            $query->bindValue(4, $_POST["total_calificacion"]);
            $query->bindValue(5, $_POST["observaciones"]);
            $query->bindValue(6, $_POST["id_banda"]);
            $query->execute();
            $ultimoid=$db->lastInsertId();

            for ($i=0; $i<$_POST["numerodecriterios"];$i++){
                $query = $db->prepare("INSERT INTO detalle_calificacion (id_calificacion, id_criterioevaluacion, puntaje) VALUES (?, ?, ?);");
                $query->bindValue(1, $ultimoid);
                $query->bindValue(2, $_POST["id_criterioevaluacion-".$i]);
                $query->bindValue(3, $_POST["puntaje-".$i]);
                $query->execute();
            }
            header("Location: inicio.php");
        } catch (Exception $ex) {
            return $ex."No se pudo completar el guardado de la calificación";
        }
?>