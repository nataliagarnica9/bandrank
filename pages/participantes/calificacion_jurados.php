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
            <table>
                <tr>
                    <td><label for="nombre">Nombre de la Banda:</label></td>
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
                    <td><label for="nombre_ubicacion">Lugar de Procendecia:</label></td>
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
                    <td><label for="nombres">Jurado:</label></td>
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
                <tr>
                    <th>Total</th>
                    <th>&nbsp;</th>
                    <th><input name="total_calificacion" type="text" id="total_aspectos" class="form-control" readonly></th>
                </tr>
            </table>
            <!-- Fin de la inserción de la tabla -->
            <tr>
                <td><label for="observaciones">Observaciones:</label></td>
                <td><textarea class="form-control" name="observaciones" rows="4" cols="15"></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit" class="btn-bandrank">Guardar Calificación</button></td>
            </tr>
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