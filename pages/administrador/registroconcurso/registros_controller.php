<?php
include "Registro.php";

// Valido si la peticion tiene la accion
if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'guardar':
            guardar();
            break;
        default:
            echo 'No existe una petición válida <a href="registros.php">Regresar</a>';
            break;
    }
}

// Creo las funciones que me conectan al modelo
function guardar() {
    include "../../../config.php";

    // Inicio el objeto del modelos
    $categorias_concurso_model = new Registro($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $categorias_concurso_model->guardar($_POST);
    if($result) {
        header("location:registros.php?status=success");
    } else {
        header("location:registros.php?message_error");
    }
}