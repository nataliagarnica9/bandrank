<?php

require_once('config.php');

$_SESSION["ROL"] = "";
$_SESSION["ID_USUARIO"] = "";

switch($_REQUEST["type"]) {
    case 'login':
        $query_usuario = $db->prepare("SELECT tipo_usuario, id_registro FROM login WHERE correo = ? and clave = ?");
        $query_usuario->bindValue(1, $_POST["correo"]);
        $query_usuario->bindValue(2, $_POST["clave"]);
        $query_usuario->execute();
        $fetch_usuario = $query_usuario->fetch(PDO::FETCH_OBJ);

        if($fetch_usuario->id_registro != null && $fetch_usuario->id_registro != "") {
            $_SESSION["ROL"] = $fetch_usuario->tipo_usuario;
            $_SESSION["ID_USUARIO"] = $fetch_usuario->id_registro;

            switch($fetch_usuario->tipo_usuario) {
                case 'jurado':
                    $sel_concurso = $db->prepare("SELECT id_concurso FROM jurado WHERE id_jurado = ?");
                    break;
                case 'instructor':
                    $sel_concurso = $db->prepare("SELECT id_concurso FROM banda WHERE id_banda = ?");
                    break;    
            }
            $sel_concurso->bindValue(1, $fetch_usuario->id_registro);
            $sel_concurso->execute();
            $fetch_concurso = $sel_concurso->fetch(PDO::FETCH_OBJ);

            $_SESSION["ID_CONCURSO"] = $fetch_concurso->id_concurso;

            echo json_encode(['status'=>'success']);
        } else {
            //Valido si existe solo el correo
            $query_correo = $db->prepare("SELECT tipo_usuario, id_registro FROM login WHERE correo = ?");
            $query_correo->bindValue(1, $_POST["correo"]);
            $query_correo->execute();
            $fetch_correo = $query_correo->fetch(PDO::FETCH_OBJ);
            if($fetch_correo->id_registro != null && $fetch_correo->id_registro != "") {
                echo json_encode(['status'=>'error', 'message'=>'Clave incorrecta']);
            } else {
                echo json_encode(['status'=>'error', 'message'=>'No se encontró un usuario con el correo proporcionado']);
            }
        }

        break;
    case 'admin':   
        // Obtengo el valor que llega desde la petición
        $clave = md5($_POST["vlr_autenticacion"]);
            
        $query = $db->query("SELECT clave_administrador FROM autenticacion");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
            
        if($clave == $fetch->clave_administrador) {
            $_SESSION["ROL"] = "admin";
            echo json_encode(['status'=>'success']);
        } else {
            echo json_encode(['status'=>'error']);
        } 
        break;
    case 'logout':   
            session_destroy();
            header("Location: ". base_url . "inicio.php");
            break;
}