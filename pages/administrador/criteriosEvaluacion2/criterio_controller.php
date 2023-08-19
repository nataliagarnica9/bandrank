<?php
include "Criterios.php";
include '../../../config.php';

// Valido si la petición tiene la acción
if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'crear_criterio':
            crear_criterio();
            break;
        case 'response':
            response();
            break;
        case 'guardar':
            guardar();
            break;
        case 'datos_criterio':
            datos_criterio();
            break;
        default:
            header("location:criteriosMain.php");
            break;
    }
}

function crear_criterio()
{
    include '../../../config.php';

    include 'creacionCriterios.php';
}

// Creo las funciones que me conectan al modelo
function guardar()
{
    include "../../../config.php";

    // Inicio el objeto del modelo
    $criterios_model = new Criterios($db);
    
    // Verifica si se enviaron datos desde el formulario
    if ($_POST) {
        $result = $criterios_model->guardar($_POST);
        
        if ($result) {
            header("location:criteriosMain.php?status=success");
        } else {
            header("location:criteriosMain.php?message_error");
        }
    }
}


function response()
{
    include '../../../config.php';

    $modelo = new Criterios($db);
    $params = $_REQUEST;
    $response = $modelo->response($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->nombre_criterio,
            $row->rango_calificacion,
            $row->nombre_planilla
        ]);
    }

    foreach ($data as $i => $criterio) {

        $data[$i][3] .= '
                    

                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarDatosCriterio(\'' . $criterio[0] . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                    </a>
                    &nbsp;
                    
                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarCriterio(\'' . $criterio[0] . '\')">
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

function datos_criterio(){
    include "../../../config.php";

    $id = $_REQUEST["id"];

    // Inicio el objeto del modelo
    $criterios_model = new Criterios($db);
    $datos_criterio = $criterios_model->getDatosCriterio($id);

    echo json_encode(["status"=>"success", "data"=>$datos_criterio]);
}
function eliminarCriterio()
{
    include '../../../config.php';

    if(isset($_POST['id'])) {
        $id_criterio = $_POST['id'];

        // Inicializa el objeto del modelo
        $criterios_model = new Criterios($db);
        
        if ($criterios_model->eliminarCriterio($id_criterio)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el criterio']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del criterio no proporcionado']);
    }
}


