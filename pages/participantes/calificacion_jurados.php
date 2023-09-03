<?php
include_once('../../config.php');
if($_SESSION["ROL"] == 'instructor') {
    header("Location: inicio.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<?php require("../../head.php"); ?>

<body>
    <?php require("../../navbar.php"); ?>

    <div class="container mt-navbar">
        <h3>Cuadro de calificación de bandas marciales</h3>

        <form action="procesar_calificacion.php" method="POST">
        <input type="hidden" name="id_concurso" value="<?=$_REQUEST["concurso"]?>">
        <input type="hidden" name="id_categoria" value="<?=$_REQUEST["categoria"]?>">
        <input type="hidden" name="id_banda" value="<?=$_REQUEST["banda"]?>">
        <input type="hidden" name="id_planilla" value="<?=$_REQUEST["planilla"]?>">
            <table class="table">
                <tr>
                    <td style="width: 14vw;border-bottom: 0px;"><label for="nombre">Nombre de la Banda:</label></td>
                    <td>
                        <?php
                    $consulta1 = $db->prepare("SELECT * FROM banda where id_banda = ?");
                    $consulta1->bindValue(1,$_REQUEST["banda"]);
                    $consulta1->execute();
                    $fetch_consulta1 = $consulta1->fetch(PDO::FETCH_OBJ);
                    echo $fetch_consulta1->nombre;
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 14vw;border-bottom: 0px;"><label for="nombre_ubicacion">Lugar de Procendecia:</label></td>
                    <td>
                        <?php
                    $consulta2 = $db->prepare("SELECT * FROM banda where id_banda = ?");
                    $consulta2->bindValue(1,$_REQUEST["banda"]);
                    $consulta2->execute();
                    $fetch_consulta2 = $consulta2->fetch(PDO::FETCH_OBJ);
                    echo $fetch_consulta2->ubicacion;
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 14vw;border-bottom: 0px;"><label for="nombres">Jurado:</label></td>
                    <td>
                        <?php
                    $consulta3 = $db->prepare("SELECT * FROM jurado where id_jurado = ?");
                    $consulta3->bindValue(1,$_SESSION["ID_USUARIO"]);
                    $consulta3->execute();
                    $fetch_consulta3 = $consulta3->fetch(PDO::FETCH_OBJ);
                    echo $fetch_consulta3->nombres." ".$fetch_consulta3->apellidos;
                    ?>
                    </td>
                </tr>
            </table>
            <!-- Aquí se inserta la tabla con los aspectos a evaluar -->
            <table class="table table-striped-columns">
                <th>Aspectos a Evaluar</th>
                <th>Rango</th>
                <th>Valoración (0-10)</th>
                <?php
                                       $consulta1_1 = $db->prepare("SELECT * FROM criterio where id_planilla = ?");
                                       $consulta1_1->bindValue(1,$_REQUEST["planilla"]);
                                       $consulta1_1->execute();
                                       $fetch_consulta1_1 = $consulta1_1->fetchAll(PDO::FETCH_OBJ);
                                       ?>
                                       <input type="hidden" name="numerodecriterios" value="<?=count($fetch_consulta1_1)?>">
                                       <?php
                                      foreach ($fetch_consulta1_1 as $i=>$planilla) {?>
                <tr>
                    <td><?=$planilla->nombre_criterio?></td>
                    <td>0-<?=$planilla->rango_calificacion?></td>
                    <td><input type="number" min="0" max="<?=$planilla->rango_calificacion?>" step="0.1" name="puntaje-<?=$i?>">
                    <input type="hidden" name="id_criterioevaluacion-<?=$i?>" value="<?=$planilla->id_criterio?>"></td>
                </tr>
                <?php
                                        }
                                        ?>
                </tr>




                <!--Penalización-->

                <!--Penalización-->




                <tr>
                    <th>Total</th>
                    <th>&nbsp;</th>
                    <th><input name="total_calificacion" type="text" id="total_aspectos" class="form-control" readonly></th>
                </tr>
<!----------------------------------Select de penalizaciones------------------------------>
<!----------------------------------Select de penalizaciones------------------------------>
                <td><label for="penalizacion">Penalizaciones:</label></td>
<td>
    <div id="penalizaciones-container">
        <!-- Contenedor para las penalizaciones -->
        <select name="penalizacion[]" class="form-control">
            <option value="">Selecciona una penalización</option>
            <?php
            // Consulta para obtener las penalizaciones
            $consulta_penalizaciones = $db->prepare("SELECT * FROM penalizacion WHERE eliminado = 0");
            $consulta_penalizaciones->execute();
            $penalizaciones = $consulta_penalizaciones->fetchAll(PDO::FETCH_OBJ);

            foreach ($penalizaciones as $penalizacion) {
                $nombre_penalizacion = $penalizacion->descripcion_penalizacion;

                // Verifica si el tipo de penalización es "Descalificación"
                if ($penalizacion->tipo_penalizacion === 'Descalificación') {
                    $nombre_penalizacion = $penalizacion->descripcion_penalizacion . ' (Descalificación)';
                }

                // Muestra el nombre de la penalización y su valor en la opción
                echo '<option value="' . $penalizacion->id_penalizacion . '">' . $nombre_penalizacion . ' (-' . $penalizacion->puntaje_penalizacion . ' puntos)</option>';
            }
            ?>
        </select>
        <button type="button" class=" btn-bandrank btn-add-penalizacion"style="padding: 6px 9px; font-size: 14px;">Agregar Penalización</button>
    </div>
</td>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const penalizacionesContainer = document.getElementById('penalizaciones-container');
        const btnAddPenalizacion = document.querySelector('.btn-add-penalizacion');

        // Función para agregar un campo de penalización
        function agregarCampoPenalizacion() {
            const nuevoCampoPenalizacion = document.createElement('div');
            nuevoCampoPenalizacion.innerHTML = `
                <select name="penalizacion[]" class="form-control">
                    <option value="">Selecciona una penalización</option>
                    <?php
                    // Consulta para obtener las penalizaciones
                    $consulta_penalizaciones = $db->prepare("SELECT * FROM penalizacion WHERE eliminado = 0");
                    $consulta_penalizaciones->execute();
                    $penalizaciones = $consulta_penalizaciones->fetchAll(PDO::FETCH_OBJ);

                    foreach ($penalizaciones as $penalizacion) {
                        $nombre_penalizacion = $penalizacion->descripcion_penalizacion;

                        // Verifica si el tipo de penalización es "Descalificación"
                        if ($penalizacion->tipo_penalizacion === 'Descalificación') {
                            $nombre_penalizacion = $penalizacion->descripcion_penalizacion . ' (Descalificación)';
                        }

                        // Muestra el nombre de la penalización y su valor en la opción
                        echo '<option value="' . $penalizacion->id_penalizacion . '">' . $nombre_penalizacion . ' (-' . $penalizacion->puntaje_penalizacion . ' puntos)</option>';
                    }
                    ?>
                </select>
                <button type="button" class="btn-bandrank btn-remove-penalizacion"style="padding: 6px 9px; font-size: 14px;">Eliminar</button>
            `;
            penalizacionesContainer.appendChild(nuevoCampoPenalizacion);
        }

        // Función para eliminar un campo de penalización
        function eliminarCampoPenalizacion(event) {
            const campoPenalizacion = event.target.parentElement;
            if (penalizacionesContainer.children.length > 1) {
                penalizacionesContainer.removeChild(campoPenalizacion);
            }
        }

        btnAddPenalizacion.addEventListener('click', agregarCampoPenalizacion);

        penalizacionesContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('btn-remove-penalizacion')) {
                eliminarCampoPenalizacion(event);
            }
        });
    });
</script>
<!----------------------------------Select de penalizaciones------------------------------>
<!----------------------------------Select de penalizaciones------------------------------>
            </table>
        </form>
    </div>
    <script>
                const valoracionInputs = document.querySelectorAll('input[type="number"]');
                const totalAspectosInput = document.getElementById('total_aspectos');

                valoracionInputs.forEach(input => {
                    input.addEventListener('input', () => {
                        let totalAspectos = 0;
                        valoracionInputs.forEach(input => {
                            const valoracion = parseFloat(input.value) || 0;
                            totalAspectos += valoracion;
                        });
                        totalAspectosInput.value = totalAspectos.toFixed(2);
                    });
                });
            </script>
</body>

</html>