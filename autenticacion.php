<?php

require_once('config.php');

switch($_REQUEST["type"]) {
    case 'login':
        $query_usuario = $db->prepare("SELECT tipo_usuario, id_registro FROM login WHERE correo = ? and clave = ?");
        $query_usuario->bindValue(1, $_POST["correo"]);
        $query_usuario->bindValue(2, $_POST["clave"]);
        $query_usuario->execute();
        $fetch_usuario = $query_usuario->fetch(PDO::FETCH_OBJ);

        if(count($fetch_usuario) > 0) {
            $_SESSION["ROL"] = $fetch_usuario->tipo_usuario;
            $_SESSION["ID_USUARIO"] = $fetch_usuario->id_registro;
            echo json_encode(['status'=>'success']);
        } else {
            //Valido si existe solo el correo
            $query_correo = $db->prepare("SELECT tipo_usuario, id_registro FROM login WHERE correo = ?");
            $query_correo->bindValue(1, $_POST["correo"]);
            $query_correo->execute();
            $fetch_correo = $query_correo->fetch(PDO::FETCH_OBJ);
            if(count($fetch_correo) > 0) {
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
}