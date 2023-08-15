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

                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarDatosConcurso(\'' . $concurso[0] . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                    </a>
                    &nbsp;
                    
                    <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarConcurso(\'' . $concurso[0] . '\')">
                    <span data-toggle="tooltip" title="Eliminar" class="fas fa-trash"></span>
                    </a>
                    &nbsp;';

        if($fetch_finalizado->finalizado == 0) {
            $data[$i][4] .= ' 
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarConcurso(\'' . $concurso[0] . '\')">
                <span data-toggle="tooltip" title="Finalizar" class="far fa-flag"></span>
                </a>
                &nbsp;';
        } else {
            $data[$i][4] .= ' 
                <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarConcurso(\'' . $concurso[0] . '\')">
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