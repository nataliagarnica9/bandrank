<?php

require_once('config.php');

$_SESSION["ROL"] = "";
$_SESSION["ID_USUARIO"] = "";

if($_POST["tipo"] == 'administrador') {
    // Obtengo el valor que llega desde la petición
    $clave = md5($_POST["password"]);

    $query = $db->query("SELECT clave_administrador FROM autenticacion");
    $fetch = $query->fetch(PDO::FETCH_OBJ);

    if ($clave == $fetch->clave_administrador) {
        $_SESSION["ROL"] = "admin";
        echo json_encode(['status' => 'success', 'rol' => 'admin']);
    } else {
        echo json_encode(['status' => 'error', 'rol' => '']);
    }
} else if($_POST["tipo"] == 'jurado' || $_POST["tipo"] == 'instructor') {
    $query_usuario = $db->prepare("SELECT tipo_usuario, id_registro, tipo_usuario FROM login WHERE correo = ? and clave = ?");
    $query_usuario->bindValue(1, $_POST["email"]);
    $query_usuario->bindValue(2, $_POST["password"]);
    $query_usuario->execute();
    $fetch_usuario = $query_usuario->fetch(PDO::FETCH_OBJ);

    if ($fetch_usuario->id_registro != null && $fetch_usuario->id_registro != "") {
        $_SESSION["ROL"] = $fetch_usuario->tipo_usuario;
        $_SESSION["ID_USUARIO"] = $fetch_usuario->id_registro;

        switch ($fetch_usuario->tipo_usuario) {
            case 'jurado':
                $datos_usuario = $db->prepare("SELECT CONCAT(nombres, ' ', apellidos) AS nombre_usuario FROM jurado WHERE id_jurado = ?");
                $datos_usuario->bindValue(1, $fetch_usuario->id_registro);
                $datos_usuario->execute();
                $fetch_dusuario = $datos_usuario->fetch(PDO::FETCH_OBJ);
                $_SESSION["NOMBRE_USUARIO"] = $fetch_dusuario->nombre_usuario;
                $sel_concurso = $db->prepare("SELECT id_concurso FROM jurado WHERE id_jurado = ?");
                break;
            case 'instructor':
                $datos_usuario = $db->prepare("SELECT nombre_instructor AS nombre_usuario FROM banda WHERE id_banda = ?");
                $datos_usuario->bindValue(1, $fetch_usuario->id_registro);
                $datos_usuario->execute();
                $fetch_dusuario = $datos_usuario->fetch(PDO::FETCH_OBJ);
                $_SESSION["NOMBRE_USUARIO"] = $fetch_dusuario->nombre_usuario;
                $sel_concurso = $db->prepare("SELECT id_concurso FROM banda WHERE id_banda = ?");
                break;
        }
        $sel_concurso->bindValue(1, $fetch_usuario->id_registro);
        $sel_concurso->execute();
        $fetch_concurso = $sel_concurso->fetch(PDO::FETCH_OBJ);

        $_SESSION["ID_CONCURSO"] = $fetch_concurso->id_concurso;

        echo json_encode(['status' => 'success', 'rol' => 'participante']);
    } else {
        //Valido si existe solo el correo
        $query_correo = $db->prepare("SELECT tipo_usuario, id_registro FROM login WHERE correo = ?");
        $query_correo->bindValue(1, $_POST["correo"]);
        $query_correo->execute();
        $fetch_correo = $query_correo->fetch(PDO::FETCH_OBJ);
        if ($fetch_correo->id_registro != null && $fetch_correo->id_registro != "") {
            echo json_encode(['status' => 'error', 'message' => 'Clave incorrecta']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontró un usuario con el correo proporcionado']);
        }
    }

} else if($_REQUEST["tipo"] == 'logout'){
    session_destroy();
    header("Location: ". base_url . "inicio.php");
}