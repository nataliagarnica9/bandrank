<?php
require "../../config.php";
require "Evaluaciones.php";

// Valido si la petición tiene la acción
if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'guardar_criterios':
            guardarCriterios();
            break;
        case 'mostrar_criterios':
            mostrarCriterios();
            break;
        default:
            echo 'No existe una petición válida <a href="evaluacion.php">Regresar</a>';
            break;
    }
}

// Creo las funciones que se conectan al modelo
function guardarCriterios() {
    global $db; // Hacemos global la variable $db para poder usarla dentro de la función
    // Inicio el objeto del modelo y le paso la conexión de la base de datos
    $evaluacion_model = new Evaluacion($db);
    
    // Utilizo la función guardarCriterios del modelo y almaceno su valor
    $result = $evaluacion_model->guardarCriterios($_POST['criterios']);
    
    if($result) {
        header("location:evaluacion.php?status=success");
    } else {
        header("location:evaluacion.php?message_error");
    }
}

function mostrarCriterios() {
    global $db; // Hacemos global la variable $db para poder usarla dentro de la función
    // Inicio el objeto del modelo y le paso la conexión de la base de datos
    $evaluacion_model = new Evaluacion($db);
    
    // Obtener los criterios de evaluación desde el modelo
    $criterios = $evaluacion_model->obtenerCriterios();

    // Incluir la vista para mostrar los criterios
    require "mostrar_criterios.php";
    exit();
}
?>
