<?php
include "Penalizaciones.php"; // Asegúrate de tener el archivo Penalizaciones.php en la ubicación correcta
include '../../../config.php';

// Valido si la petición tiene la acción
if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'eliminarPenalizacion':
            eliminarPenalizacion();
            break;
        case 'response':
            response();
            break;
        case 'guardar':
            guardar();
            break;
        case 'verPenalizacionesEliminadas':
            verPenalizacionesEliminadas();
            break;
        case 'restaurarPenalizacion':
            restaurarPenalizacion();
            break;
        case 'eliminarPenalizacionDefinitivamente':
            eliminarPenalizacionDefinitivamente();
            break;
        case 'actualizar':
            actualizar();
            break;
        case 'actualizar_penalizacion':
            actualizar_penalizacion();
            break;
         case 'obtener_puntaje_penalizacion':
            obtenerPuntajeCalificacion();
            break;
        default:
            header("location:penalizacionMain.php"); // Ajusta la redirección a la página principal de penalizaciones
            break;
    }
}

// En el controlador penalizacion_controller.php
function guardar()
{
    include "../../../config.php";

    // Inicio el objeto del modelo
    $penalizaciones_model = new Penalizaciones($db);

    // Verifica si se enviaron datos desde el formulario
    if ($_POST) {
        $descripcion_penalizacion = $_POST["descripcion_penalizacion"];
        $tipo_penalizacion = $_POST["tipo_penalizacion"];
        $puntaje_penalizacion = ($tipo_penalizacion === "Descalificación") ? 0 : $_POST["puntaje_penalizacion"];
        $id_planilla = $_POST["id_planilla"];

        $data = [
            "descripcion_penalizacion" => $descripcion_penalizacion,
            "tipo_penalizacion" => $tipo_penalizacion,
            "puntaje_penalizacion" => $puntaje_penalizacion,
            "id_planilla" => $id_planilla
        ];

        $result = $penalizaciones_model->guardar($data);

        if ($result) {
            header("location:penalizacionMain.php?status=success");
        } else {
            header("location:penalizacionMain.php?message_error");
        }
    }
}


function response()
{ 
    include '../../../config.php';

    $modelo = new Penalizaciones($db); // Asegúrate de que Penalizaciones sea el nombre correcto de la clase
    $params = $_REQUEST;
    $response = $modelo->response($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->descripcion_penalizacion,
            $row->tipo_penalizacion,
            $row->puntaje_penalizacion,
            '
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarPenalizacion(\'' . $row->id_penalizacion . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                </a>
                &nbsp;
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarPenalizacion(\'' . $row->id_penalizacion . '\')">
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

function eliminarPenalizacion()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_penalizacion = $_POST['id'];

        // Inicializa el objeto del modelo
        $penalizaciones_model = new Penalizaciones($db); // Asegúrate de que Penalizaciones sea el nombre correcto de la clase

        if ($penalizaciones_model->eliminarPenalizacion($id_penalizacion)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la penalización']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de la penalización no proporcionado']);
    }
}

function verPenalizacionesEliminadas()
{
    include '../../../config.php';

    $modelo = new Penalizaciones($db); // Asegúrate de que Penalizaciones sea el nombre correcto de la clase
    $params = $_REQUEST;
    $response = $modelo->verPenalizacionesEliminadas($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->descripcion_penalizacion,
            $row->tipo_penalizacion,
            $row->puntaje_penalizacion,
            '
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="restaurarPenalizacion(\'' . $row->id_penalizacion . '\')">
                    <span data-toggle="tooltip" title="Restaurar" class="fas fa-undo"></span>
                </a>
                &nbsp;
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarPenalizacionDefinitivamente(\'' . $row->id_penalizacion . '\')">
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

// Agrega aquí las funciones correspondientes a las demás acciones de penalizaciones >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

function restaurarPenalizacion()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_penalizacion = $_POST['id'];

        // Inicializa el objeto del modelo
        $penalizaciones_model = new Penalizaciones($db);

        if ($penalizaciones_model->restaurarPenalizacion($id_penalizacion)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al restaurar la penalización']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de la penalización no proporcionado']);
    }
}

function eliminarPenalizacionDefinitivamente()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_penalizacion = $_POST['id'];

        // Inicializa el objeto del modelo
        $penalizaciones_model = new Penalizaciones($db);

        if ($penalizaciones_model->eliminarPenalizacionDefinitivamente($id_penalizacion)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar definitivamente la penalización']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de la penalización no proporcionado']);
    }
}

function actualizar()
{
    include "../../../config.php";

    // Inicio el objeto del modelo
    $penalizacion_model = new Penalizaciones($db); 

    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $penalizacion_model->actualizar($_POST);
    
    if ($result) {
        header("location:penalizacionMain.php?status=success");
    } else {
        header("location:penalizacionMain.php?message_error");
    }
}

function actualizar_penalizacion()
{
    include '../../../config.php';

    $penalizacion_model = new Penalizaciones($db);
    $id = $_REQUEST["id"];
    $datos = $penalizacion_model->getPenalizacionById($id);

    include 'modificarPenalizacion.php';
}

function obtenerPuntajeCalificacion()
{
    include '../../../config.php';

    $penalizacion_model = new Penalizaciones($db);
    $id = $_REQUEST["id"];
    $datos = $penalizacion_model->getPuntajePenalizacionById($id);

    echo json_encode(["id" => $datos->puntaje_penalizacion, "tipo"=>$datos->tipo_penalizacion]);
}
?>
