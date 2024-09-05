<?php
include "Registro.php";

// Valido si la peticion tiene la accion
if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'guardar':
            guardar();
            break;
        case 'response':
            response();
            break;
        case 'eliminar':
            eliminar();
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
    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status'=>'error']);
    }
}

function response() {
    include "../../../config.php";
    $modelo = new Registro($db);
    $params=$_REQUEST;
    $response = $modelo->response($params);
    $data = array();

    foreach($response['data'] as $i => $row){
        array_push($data, [
            $row->nombre_categoria,
        ]);
    }

    foreach ($data as $i => $categoria) {

        $data[$i][1] .= '
                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminar(\'' . $categoria[0] . '\')">
                    <span data-toggle="tooltip" title="Eliminar" class="fas fa-trash"></span>
                    </a>
                    &nbsp;';
    }

    $jsonData = array(
        "draw" => intval($params['draw']),
        "recordsTotal" => intval($response['totalTableRows']),
        "recordsFiltered" => intval($response['totalTableRows']),
        "data" => $data
    );
    echo json_encode($jsonData);
}

function eliminar()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Inicializa el objeto del modelo
        $model = new Registro($db);

        if ($model->eliminar($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el concurso']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del concurso no proporcionado']);
    }
}