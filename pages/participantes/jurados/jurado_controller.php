<?php
include "Jurado.php";

// Valido si la peticion tiene la accion
if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'guardar':
            guardar();
            break;
        default:
            echo 'No existe una petición válida <a href="jurados.php">Regresar</a>';
            break;
    }
}

// Creo las funciones que me conectan al modelo
function guardar() {
    include "../../config.php";

    // Inicio el objeto del modelo
    $jurado_model = new Jurado($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $jurado_model->guardar($_POST);
    if($result) {
        header("location:jurados.php?status=success");
    } else {
        header("location:jurados.php?message_error");
    }
}