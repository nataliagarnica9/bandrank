<?php
include "Planillas.php";
include '../../../config.php';

if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'crear_planilla':
            crear_planilla();
            break;
        case 'response':
            response();
            break;
        case 'guardar':
            guardar();
            break;
        case 'datos_planilla':
            datos_planilla();
            break;
        case 'eliminarPlanilla':
            eliminarPlanilla();
            break;
        default:
            header("location:planillasMain.php");
            break;
    }
}

function crear_planilla()
{
    include '../../../config.php';

    include 'creacionPlanilla.php';
}

function response()
{
    include '../../../config.php';

    $modelo = new Planillas($db);
    $params = $_REQUEST;
    $response = $modelo->response($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->nombre_planilla,
            $row->nombre_concurso
        ]);
    }

    foreach ($data as $i => $planilla) {

        $data[$i][2] .= '
            <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="verDatosPlanilla(\'' . $planilla[0] . '\')">
                <span data-toggle="tooltip" title="Ver detalles" class="fas fa-eye"></span>
            </a>
            &nbsp;
            <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarPlanilla(\'' . $planilla[0] . '\')">
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

function guardar()
{
    include "../../../config.php";

    $planillas_model = new Planillas($db);

    if ($_POST) {
        $result = $planillas_model->guardar($_POST);

        if ($result) {
            $status = 'success'; // Agregamos esta línea para mostrar el mensaje de éxito
        }
    }

    include "creacionPlanilla.php"; // Redirigimos de vuelta a la página de creación con el mensaje
}

function datos_planilla(){
    include "../../../config.php";

    $id = $_REQUEST["id"];

    $planillas_model = new Planillas($db);
    $datos_planilla = $planillas_model->getDatosPlanilla($id);

    echo json_encode(["status"=>"success", "data"=>$datos_planilla]);
}

function eliminarPlanilla()
{
    include '../../../config.php';

    if(isset($_POST['id'])) {
        $id_planilla = $_POST['id'];

        $planillas_model = new Planillas($db);

        if ($planillas_model->eliminarPlanilla($id_planilla)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la planilla']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de la planilla no proporcionado']);
    }
}
?>
