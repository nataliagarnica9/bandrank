<?php
include 'Concurso.php';
error_reporting(0);

if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]):
        case 'crear_concurso':
            crear_concurso();
            break;
        case 'save':
            save();
            break;
        case 'response':
            response();
            break;
        case 'actualizar_concurso';
        actualizar_concurso();
             break;
        case 'actualizar';
            actualizar();
             break;
         case 'datos_concurso';
            datos_concurso();
             break;
         case 'verConcursosEliminados';
             verConcursosEliminados();
             break;
         case 'eliminarConcurso';
             eliminarConcurso();
             break;
         case 'restaurarConcurso';
             restaurarConcurso();
             break;
         case 'eliminarConcursoDefinitivamente':
             eliminarConcursoDefinitivamente();
             break;

        default:
            header("location:concursos.php");
        break;
    endswitch;

}

function crear_concurso() {
    include '../../../config.php';
    
    include 'creacionConcurso.php';
}

function save() {
    include '../../../config.php';

    // Inicio el objeto del modelo
    $concurso_model = new Concurso($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $concurso_model->save($_POST);
    if($result) {
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error']);
    }
}

function response() {
    include '../../../config.php';

    $modelo = new Concurso($db);
    $params=$_REQUEST;
    $response = $modelo->response($params);
    $data = array();

    foreach($response['data'] as $i => $row){
        array_push($data, [
            $row->id_concurso,
            $row->nombre_concurso,
            $row->ubicacion,
            $row->director
        ]);
    }

    foreach ($data as $i => $concurso) {

        $query_finalizado = $db->prepare("SELECT finalizado FROM concurso WHERE id_concurso = ?");
        $query_finalizado->bindValue(1, $concurso->id_concurso);
        $fetch_finalizado = $query_finalizado->fetch(PDO::FETCH_OBJ);

        $data[$i][4] .= '
                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="verDatosConcurso(\'' . $concurso[0] . '\')">
                    <span data-toggle="tooltip" title="Ver" class="far fa-eye"></span>
                    </a>
                    &nbsp;

                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarConcurso(\'' . $concurso[0] . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                    </a>
                    &nbsp;
                    
                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarConcurso(\'' . $concurso[0] . '\')">
                    <span data-toggle="tooltip" title="Eliminar" class="fas fa-trash"></span>
                    </a>
                    &nbsp;';

        if($fetch_finalizado->finalizado == 0) {
            $data[$i][4] .= ' 
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="finalizarConcurso(\'' . $concurso[0] . '\')">
                <span data-toggle="tooltip" title="Finalizar" class="far fa-flag"></span>
                </a>
                &nbsp;';
        } else {
            $data[$i][4] .= ' 
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="finalizarConcurso(\'' . $concurso[0] . '\')">
                <span data-toggle="tooltip" title="Finalizado" class="fas fa-flag"></span>
                </a>
                &nbsp;';
        }            
    }

    $jsonData = array(
        "draw" => intval($params['draw']),
        "recordsTotal" => intval($response['totalTableRows']),
        "recordsFiltered" => intval($response['totalTableRows']),
        "data" => $data
    );
    echo json_encode($jsonData);
}
    /////////////////////////////////

function actualizar_concurso() {
    include '../../../config.php';
    $concurso_model = new Concurso($db); 
    $id = $_REQUEST["id"];
    $datos = $concurso_model->getConcursoById($id); 
    include 'modificarConcurso.php'; 
} 

    function actualizar()
{
    include "../../../config.php";

    // Inicio el objeto del modelo
    $concurso_model = new Concurso($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $concurso_model->actualizar($_POST);
    
    if ($result) {
        header("location:concursos.php?status=success");
    } else {
        header("location:concursos.php?message_error");
    }
}

function datos_concurso() {
    include "../../../config.php";

    $id = $_REQUEST["id"];

    // Inicio el objeto del modelo para los concursos
    $concurso_model = new Concurso($db);
    $datos_concurso = $concurso_model->getConcursoById($id);

    echo json_encode(["status" => "success", "data" => $datos_concurso]);
}

// Funciones de eliminacion

function eliminarConcurso()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_concurso = $_POST['id'];

        // Inicializa el objeto del modelo
        $concurso_model = new Concurso($db);

        if ($concurso_model->eliminarConcurso($id_concurso)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el concurso']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del concurso no proporcionado']);
    }
}

function verConcursosEliminados()
{
    include '../../../config.php';

    $modelo = new Concurso($db);
    $params = $_REQUEST;
    $response = $modelo->verConcursosEliminados($params);
    $data = array();

    foreach ($response['data'] as $i => $row) {
        array_push($data, [
            $row->id_concurso,
            $row->nombre_concurso,
            $row->ubicacion,
            $row->director,
            '
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="restaurarConcurso(\'' . $row->id_concurso . '\')">
                    <span data-toggle="tooltip" title="Restaurar" class="fas fa-undo"></span>
                </a>
                &nbsp;
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarConcursoDefinitivamente(\'' . $row->id_concurso . '\')">
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

function restaurarConcurso()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_concurso = $_POST['id'];

        // Inicializa el objeto del modelo
        $concurso_model = new Concurso($db);
        if ($concurso_model->restaurarConcurso($id_concurso)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al restaurar el concurso']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del concurso no proporcionado']);
    }
}

function eliminarConcursoDefinitivamente()
{
    include '../../../config.php';

    if (isset($_POST['id'])) {
        $id_concurso = $_POST['id'];

        // Inicializa el objeto del modelo
        $concurso_model = new Concurso($db);

        if ($concurso_model->eliminarConcursoDefinitivamente($id_concurso)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar definitivamente el concurso']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del concurso no proporcionado']);
    }
}
