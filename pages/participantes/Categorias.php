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
    <h3> Elija la categoria </h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Opción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Datos de ejemplo de categorías
            $categorias = $db->prepare("select * from categorias_concurso where eliminado = 0");
            $categorias->execute();
            $fetch_categorias = $categorias->fetchAll(PDO::FETCH_OBJ);


            // Generar filas de la tabla con los datos de las categorías
            foreach ($fetch_categorias as $categoria) {?>
            <tr>
                <td><?=$categoria->nombre_categoria?></td>
                <td><a href="eleccionbandas.php?concurso=<?=$_REQUEST['concurso']?>&categoria=<?=$categoria->id_categoria?>" class="btn-bandrank">Seleccionar</a></td>
                
            </tr>

            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="inicio.php" class="btn-bandrank">Volver</a>
</body>
</html>