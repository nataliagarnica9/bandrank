        <?php
        include "Planillas.php";
        include '../../../config.php';

        // Valido si la petición tiene la acción
        if (isset($_REQUEST["action"])) {
            switch ($_REQUEST["action"]) {
                case 'eliminarPlanilla':
                    eliminarPlanilla();
                    break;
                case 'crear_planilla':
                    crear_planilla();
                    break;
                case 'response':
                    response();
                    break;
                case 'guardar':
                    guardar();
                    break;
                case 'verPlanillasEliminadas':
                    verPlanillasEliminadas();
                    break;
                case 'restaurarPlanilla':
                    restaurarPlanilla();
                    break;
                case 'eliminarPlanillaDefinitivamente':
                    eliminarPlanillaDefinitivamente();
                    break;
                case 'actualizar_planilla':
                    actualizar_planilla();
                    break;
                case 'actualizar':
                    actualizar();
                    break;
                default:
                    header("location:planillaMain.php");
                    break;
            }
        }

        function crear_planilla()
        {
            include '../../../config.php';

            include 'creacionPlanilla.php';
        }

        // Creo las funciones que me conectan al modelo
        function guardar()
        {
            include "../../../config.php";

            // Inicio el objeto del modelo
            $planillas_model = new Planillas($db);

            // Verifica si se enviaron datos desde el formulario
            if ($_POST) {
                $result = $planillas_model->guardar($_POST);

                if ($result) {
                    header("location:planillaMain.php?status=success");
                } else {
                    header("location:planillaMain.php?message_error");
                }
            }
            
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
                    $row->nombre_concurso,
                    '
                        <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="editarPlanilla(' . $row->id_planilla .  ')">
                        <span data-toggle="tooltip" title="Editar" class="fas fa-pencil-alt"></span>
                        </a>
                        &nbsp;
                        <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarPlanilla(' . $row->id_planilla . ')">
                            <span data-toggle="tooltip" title="Eliminar" class="fas fa-trash"></span>
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


        function eliminarPlanilla()
        {
            include '../../../config.php';

            if (isset($_POST['id'])) {
                $id_planilla = $_POST['id'];

                // Inicializa el objeto del modelo
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

        function verPlanillasEliminadas()
        {
            include '../../../config.php';

            $modelo = new Planillas($db);
            $params = $_REQUEST;
            $response = $modelo->verPlanillasEliminadas($params);
            $data = array();

            foreach ($response['data'] as $i => $row) {
                array_push($data, [
                    $row->nombre_planilla,
                    $row->nombre_concurso,
                    '
                        <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="restaurarPlanilla(' . $row->id_planilla . ')">
                            <span data-toggle="tooltip" title="Restaurar" class="fas fa-undo"></span>
                        </a>
                        &nbsp;
                        <a href="javascript:void(0)" style="color:#FF751F;text-decoration: none;" onclick="eliminarPlanillaDefinitivamente(' . $row->id_planilla . ')">
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

        function restaurarPlanilla()
        {
            include '../../../config.php';

            if (isset($_POST['id'])) {
                $id_planilla = $_POST['id'];

                // Inicializa el objeto del modelo
                $planillas_model = new Planillas($db);
                if ($planillas_model->restaurarPlanilla($id_planilla)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al restaurar la planilla']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de la planilla no proporcionado']);
            }
        }

        function eliminarPlanillaDefinitivamente()
        {
            include '../../../config.php';

            if (isset($_POST['id'])) {
                $id_planilla = $_POST['id'];

                // Inicializa el objeto del modelo
                $planillas_model = new Planillas($db);

                if ($planillas_model->eliminarPlanillaDefinitivamente($id_planilla)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar definitivamente la planilla']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de la planilla no proporcionado']);
            }
        }

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

/* function editarPlanilla() {
    include "../../../config.php";

    // Inicio el objeto del modelo
    $planilla_model = new Planillas($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $planilla_model->editarPlanilla($_POST, $_FILES);
    if ($result) {
        header("location:planillaMain.php?status=success");
    } else {
        header("location:planillaMain.php?message_error");
    }
} */

function actualizar() {
    include "../../../config.php";

    // Inicio el objeto del modelo
    $planilla_model = new Planillas($db);
    // Utilizo la función guardar del modelo y almaceno su valor
    $result = $planilla_model->actualizar($_POST);
    if ($result) {
        header("location:planillaMain.php?status=success");
    } else {
        header("location:planillaMain.php?message_error");
    }
}
function actualizar_planilla() {    
    include '../../../config.php';

    $planilla_model = new Planillas($db);
    $id = $_REQUEST["id"];
    $datos = $planilla_model->getPlanillaById($id);

    include 'modificarPlanilla.php';
}