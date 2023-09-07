<?php
include("../../config.php");
include '../../services/MailerService.php';
$mailService = new MailerService();


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


        $query_banda = $db->prepare("SELECT nombre AS nombre_banda,correo_instructor,nombre_instructor FROM banda WHERE id_banda = ?;");
        $query_banda->bindValue(1, $_POST["id_banda"]);
        $query_banda->execute();
        $fetch_banda = $query_banda->fetch(PDO::FETCH_OBJ);

        $instructor = [
            "correo_instructor" => $fetch_banda->correo_instructor,
            "nombre_banda" => $fetch_banda->nombre_banda,
            "nombre_instructor" => $fetch_banda->nombre_instructor
        ];

        $query_planilla = $db->prepare("SELECT nombre_planilla FROM planilla WHERE id_planilla = ?;");
        $query_planilla->bindValue(1, $_POST["id_planilla"]);
        $query_planilla->execute();
        $fetch_planilla = $query_planilla->fetch(PDO::FETCH_OBJ);

        $nombre_planilla = $fetch_planilla->nombre_planilla;

        $instructor = [
            "correo_instructor" => $fetch_banda->correo_instructor,
            "nombre_banda" => $fetch_banda->nombre_banda,
            "nombre_instructor" => $fetch_banda->nombre_instructor
        ];

        echo $mailService->construirCorreo($db,$instructor, $nombre_planilla);

        header("Location: inicio.php");
    } catch (Exception $ex) {
        return $ex."No se pudo completar el guardado de la calificación";
    }
?>