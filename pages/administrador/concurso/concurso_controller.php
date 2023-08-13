<?php
include 'Concurso.php';

if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]):
        case 'response':
            response();
            break;
        default:
            header("location:concursos.php");
        break;
    endswitch;

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
        //variable con las opciones aplicables a cada nota credito
        $data[$i][4] .= '
                    <a href="javascript:void(0)" style="color:#000;" data-backdrop="static" data-keyboard="false" onclic="verDatosConcurso(\'' . $concurso[0] . '\')">
                    <span data-toggle="tooltip" title="Ver" class="far fa-eye"></span>
                    </a>
                    &nbsp;

                    <a href="javascript:void(0)" style="color:#000;" data-backdrop="static" data-keyboard="false" onclic="editarDatosConcurso(\'' . $concurso[0] . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                    </a>
                    &nbsp;
                    
                    <a href="javascript:void(0)" style="color:#000;" data-backdrop="static" data-keyboard="false" onclic="eliminarConcurso(\'' . $concurso[0] . '\')">
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