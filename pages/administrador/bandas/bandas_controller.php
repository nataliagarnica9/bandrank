<?php
include "Banda.php";

// Valido si la peticion tiene la accion
if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'guardar':
            guardar();
            break;
        default:
            echo 'No existe una petición válida <a href="bandas.php">Regresar</a>';
            break;
    }
}

// Creo las funciones que me conectan al modelo
function guardar() {
    include "../../../config.php";

    // Inicio el objeto del modelos
    $banda_model = new Banda($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $banda_model->guardar($_POST, $_FILES);
    if($result) {
        header("location:bandas.php?status=success");
    } else {
        header("location:bandas.php?message_error");
    }
}