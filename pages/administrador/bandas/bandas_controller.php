<?php
include "Banda.php";

// Valido si la peticion tiene la accion
if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'guardar':
            guardar();
            break;
         case 'response':
                response();
                break;
         case 'eliminarBanda':
               eliminarBanda();
                break;
         case 'actualizar':
               actualizar();
                break;
        case 'editarBandas':
                editarBandas();
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
        header("location:creacionbandas.php?status=success");
    } else {
        header("location:creacionbandas.php?message_error");
    }
}

function response()
{ 
    include '../../../config.php';

    $modelo = new Banda($db); // Asegúrate de que Penalizaciones sea el nombre correcto de la clase
    $params = $_REQUEST;
    $response = $modelo->response($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->nombre,
            $row->ubicacion,
            $row->nombre_instructor,
            '
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarBandas(\'' . $row->id_banda . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                </a>
                &nbsp;
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarBanda(\'' . $row->id_banda . '\')">
                    <span data-toggle="tooltip" title="Eliminar" class="fas fa-trash"></span>
                </a>
                &nbsp;'
        ]);
    }
    $jsonData = array(
        "draw" => intval($params['draw']),
        "recordsTotal" => intval($response['totalTableRows']),
        "recordsFiltered" => intval($response['totalTableRows']),
        "data" => $data
    );
    echo json_encode($jsonData);
}

function eliminarBanda()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_banda = $_POST['id'];

        // Inicializa el objeto del modelo
        $banda_model = new Banda($db); // Asegúrate de que Penalizaciones sea el nombre correcto de la clase

        if ($banda_model->eliminarBanda($id_banda)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la banda']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de la banda no proporcionado']);
    }
}

function actualizar()
{
    include "../../../config.php";

    // Inicio el objeto del modelo
    $banda_model = new Banda($db); 

    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $banda_model->actualizar($_POST);
    
    if ($result) {
        header("location:bandas.php?status=success");
    } else {
        header("location:bandas.php?message_error");
    }
}

function editarBandas()
{
    include '../../../config.php';

    $banda_model = new Banda($db);
    $id = $_REQUEST["id"];
    $datos = $banda_model->getBandaById($id);

    include 'modificarbandas.php';
}