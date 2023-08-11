<?php
// eliminar_criterio.php

// Verificamos si se envió el ID del criterio a eliminar
if (isset($_POST['id']) && !empty($_POST['id'])) {
    include "Evaluaciones.php";

    // Inicializamos la conexión a la base de datos
    include "../../../config.php";

    // Creamos el objeto del modelo
    $evaluacion_model = new Evaluacion($db);

    // Obtenemos el ID del criterio a eliminar
    $id_criterio = $_POST['id'];

    // Llamamos a la función del modelo para eliminar el criterio
    $result = $evaluacion_model->eliminarCriterio($id_criterio);

    if ($result) {
        // Si la eliminación fue exitosa, enviamos una respuesta de éxito al cliente
        echo json_encode(array('status' => 'success'));
    } else {
        // Si hubo un error en la eliminación, enviamos una respuesta de error al cliente
        echo json_encode(array('status' => 'error', 'message' => 'Error al eliminar el criterio'));
    }
} else {
    // Si no se envió el ID del criterio, enviamos una respuesta de error al cliente
    echo json_encode(array('status' => 'error', 'message' => 'ID del criterio no proporcionado'));
}
?>
