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
<?php require("../../navbar.php");?>

<div class="container mt-navbar">
    <h3> Elección de planillas </h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Planilla</th>
                <th>Opción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Datos de ejemplo de categorías
            $planilla = $db->prepare("select * from planilla where id_concurso = ?");
            $planilla->bindValue(1,$_REQUEST["concurso"]);
            $planilla->execute();
            $fetch_planilla = $planilla->fetchAll(PDO::FETCH_OBJ);


            // Generar filas de la tabla con los datos de las categorías
            foreach ($fetch_planilla as $planilla) {?>
            <tr>
                <td><?=$planilla->nombre_planilla?></td>
                <td><a href="calificacion_jurados.php?concurso=<?=$_REQUEST['concurso']?>&categoria=<?=$_REQUEST["categoria"]?>&banda=<?=$_REQUEST["banda"]?>&planilla=<?=$planilla->id_planilla?>" class="btn-bandrank">Seleccionar</a></td>
            </tr>

            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="eleccionbandas.php?concurso=<?=$_REQUEST['concurso']?>&categoria=<?=$_REQUEST['banda']?>" class="btn-bandrank">Volver</a></td>

</body>
</html>