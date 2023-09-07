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
    <h3> Listado de bandas </h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nombre de banda</th>
                <th>Opción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Datos de ejemplo de categorías
            $banda = $db->prepare("select * from banda where id_concurso = ? and id_categoria = ?");
            $banda->bindValue(1,$_REQUEST["concurso"]);
            $banda->bindValue(2,$_REQUEST["categoria"]);
            $banda->execute();
            $fetch_banda = $banda->fetchAll(PDO::FETCH_OBJ);


            // Generar filas de la tabla con los datos de las categorías
            foreach ($fetch_banda as $banda) {?>
            <tr>
                <td><?=$banda->nombre?></td>
                <td><a href="eleccionplanilla.php?concurso=<?=$_REQUEST['concurso']?>&categoria=<?=$_REQUEST["categoria"]?>&banda=<?=$banda->id_banda?>" class="btn-bandrank">Seleccionar</a></td>
                
            </tr>

            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="<?= base_url ?>pages/participantes/Categorias.php?concurso=<?= $_SESSION["ID_CONCURSO"] ?>" class="btn-bandrank"> Volver</a>

</body>
</html>