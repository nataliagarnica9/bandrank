<?php
include "Criterios.php";
include '../../../config.php';

// Valido si la petición tiene la acción
if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'eliminarCriterio':
            eliminarCriterio();
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
          case 'verCriteriosEliminados':
            verCriteriosEliminados();
            break;
        case 'restaurarCriterio':
            restaurarCriterio();
            break;
        case 'eliminarCriterioDefinitivamente':
            eliminarCriterioDefinitivamente();
            break;
            case 'actualizar':
                actualizar();
                break;
                case 'actualizar_criterio':
                    actualizar_criterio();
                    break;
        default:
            header("location:criteriosMain.php");
            break;
    }
}

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
            '0-'.$row->rango_calificacion,
            $row->nombre_planilla,
            '
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarCriterio(\'' . $row->id_criterio . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                </a>
                &nbsp;
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarCriterio(\'' . $row->id_criterio . '\')">
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
//Funciones de eliminacion
function eliminarCriterio()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
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

function verCriteriosEliminados()
{
    include '../../../config.php';

    $modelo = new Criterios($db);
    $params = $_REQUEST;
    $response = $modelo->verCriteriosEliminados($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->nombre_criterio,
            $row->rango_calificacion,
            $row->nombre_planilla,
            '
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="restaurarCriterio(\'' . $row->id_criterio . '\')">
                    <span data-toggle="tooltip" title="Restaurar" class="fas fa-undo"></span>
                </a>
                &nbsp;
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarCriterioDefinitivamente(\'' . $row->id_criterio . '\')">
                    <span data-toggle="tooltip" title="Eliminar definitivamente" class="fas fa-trash-alt"></span>
                </a>
            '
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

function restaurarCriterio()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_criterio = $_POST['id'];

        // Inicializa el objeto del modelo
        $criterios_model = new Criterios($db);
        if ($criterios_model->restaurarCriterio($id_criterio)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al restaurar el criterio']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del criterio no proporcionado']);
    }
}

function eliminarCriterioDefinitivamente()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_criterio = $_POST['id'];

        // Inicializa el objeto del modelo
        $criterios_model = new Criterios($db);

        if ($criterios_model->eliminarCriterioDefinitivamente($id_criterio)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar definitivamente el criterio']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del criterio no proporcionado']);
    }
}

function datos_criterio()
{
    include "../../../config.php";

    $id = $_REQUEST["id"];

    // Inicio el objeto del modelo
    $criterios_model = new Criterios($db);
    $datos_criterio = $criterios_model->getDatosCriterio($id);

    echo json_encode(["status" => "success", "data" => $datos_criterio]);
}

function actualizar() {
    include "../../../config.php";

    // Inicio el objeto del modelo
    $criterio_model = new Criterios($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $criterio_model->actualizar($_POST);
    if ($result) {
        header("location:criteriosMain.php?status=success");
    } else {
        header("location:criteriosMain.php?message_error");
    }
}
function actualizar_criterio() {    
    include '../../../config.php';

    $criterio_model = new Criterios($db);
    $id = $_REQUEST["id"];
    $datos = $criterio_model->getCriterioById($id);

    include 'modificarCriterio.php';
} 
?>