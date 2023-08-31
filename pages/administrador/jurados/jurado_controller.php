<?php
include "Jurado.php";

// Valido si la peticion tiene la accion
if (isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'crear_jurado':
            crear_jurado();
            break;
        case 'response':
            response();
            break;
        case 'guardar':
            guardar();
            break;
        case 'datos_jurado':
            datos_jurado();
            break;
        case 'actualizar_jurado':
            actualizar_jurado();
            break;
        case 'actualizar':
            actualizar();
            break;
        case 'inactivar':
            inactivar();
            break;        
        default:
            header("location:jurados.php");
            break;
    }
}

function crear_jurado()
{
    include '../../../config.php';

    include 'creacionJurado.php';
}

function actualizar_jurado() {
    include '../../../config.php';

    $jurado_model = new Jurado($db);
    $id = $_REQUEST["id"];
    $datos = $jurado_model->getJuradoById($id);

    include 'modificarJurado.php';
}

// Creo las funciones que me conectan al modelo
function guardar()
{
    include "../../../config.php";

    // Inicio el objeto del modelo
    $jurado_model = new Jurado($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $jurado_model->guardar($_POST, $_FILES);
    if ($result) {
        header("location:jurados.php?status=success");
    } else {
        header("location:jurados.php?message_error");
    }
}

function response()
{
    include '../../../config.php';

    $modelo = new Jurado($db);
    $params = $_REQUEST;
    $response = $modelo->response($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->nombre_completo,
            $row->documento_identificacion,
            $row->correo,
            $row->nombre_concurso,
            '
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="verDatosJurado(\'' . $row->id_jurado . '\')">
                <span data-toggle="tooltip" title="Ver" class="far fa-eye"></span>
                </a>
                &nbsp;

                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarDatosJurado(\'' . $row->id_jurado . '\')">
                <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                </a>
                &nbsp;
                
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="inactivarJurado(\'' . $row->id_jurado . '\')">
                <span data-toggle="tooltip" title="Inactivar" class="fas fa-ban"></span>
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

function datos_jurado(){
    include "../../../config.php";

    $id = $_REQUEST["id"];

    // Inicio el objeto del modelo
    $jurado_model = new Jurado($db);
    $datos_jurado = $jurado_model->getJuradoById($id);

    echo json_encode(["status"=>"success", "data"=>$datos_jurado]);
}

function actualizar() {
    include "../../../config.php";

    // Inicio el objeto del modelo
    $jurado_model = new Jurado($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $jurado_model->actualizar($_POST, $_FILES);
    if ($result) {
        header("location:jurados.php?status=success");
    } else {
        header("location:jurados.php?message_error");
    }
}

function inactivar() {
    include "../../../config.php";
    // Inicio el objeto del modelo
    $jurado_model = new Jurado($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $jurado_model->inactivar($_REQUEST["id"]);

    if ($result) {
        echo json_encode(["status"=>"success"]);
    } else {
        echo json_encode(["status"=>"error"]);
    }
}
