<?php

require_once('config.php');

// Obtengo el valor que llega desde la petición
$clave = md5($_POST["vlr_autenticacion"]);

$query = $db->query("SELECT clave_administrador FROM autenticacion");
$fetch = $query->fetch(PDO::FETCH_OBJ);

if($clave == $fetch->clave_administrador) {
    echo json_encode(['status'=>'success']);
} else {
    echo json_encode(['status'=>'error']);
}