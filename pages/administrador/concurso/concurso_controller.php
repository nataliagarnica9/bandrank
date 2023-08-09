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

    foreach ($response['data'] as $concurso) {
        //variable con las opciones aplicables a cada nota credito
        $opciones = '
                    <a href="javascript:void(0)" style="color:#000;" data-backdrop="static" data-keyboard="false" onclic="verDatosConcurso(\'' . $concurso->id_concurso . '\')">
                    <span data-toggle="tooltip" title="Ver" class="far fa-eye"></span>
                    </a>
                    &nbsp;

                    <a href="javascript:void(0)" style="color:#000;" data-backdrop="static" data-keyboard="false" onclic="editarDatosConcurso(\'' . $concurso->id_concurso . '\')">
                    <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                    </a>
                    &nbsp;
                    
                    <a href="javascript:void(0)" style="color:#000;" data-backdrop="static" data-keyboard="false" onclic="eliminarConcurso(\'' . $concurso->id_concurso . '\')">
                    <span data-toggle="tooltip" title="Eliminar" class="fas fa-trash"></span>
                    </a>
                    &nbsp;';


        array_push($response['data'], [
            $concurso->id_concurso,
            $concurso->nombre_concurso,
            $concurso->ubicacion,
            $concurso->director,
            $opciones
        ]);
    }
    $jsonData = array(
        "draw" => intval($params['draw']),
        "recordsTotal" => intval($response['totalTableRows']),
        "recordsFiltered" => intval($response['totalTableRows']),
        "data" => $response['data']
    );
    echo json_encode($jsonData);
}