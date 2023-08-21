<!DOCTYPE html>
<html lang="es">
    <?php require("../../../head.php"); ?>
<body>
<?php require("../../../navbar.php");?>

<div class="container mt-navbar">
    <form action="jurado_controller.php?action=guardar" method="POST" enctype="multipart/form-data">
        <!-- ... (código del formulario) ... -->
    </form>

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
            $categorias = $db->prepare("select * from categorias_concurso where eliminado = 0 and id_concurso=?");
            $categorias->bindValue(1,$_REQUEST["concurso"]);
            $categorias->execute();
            $fetch_categorias = $categorias->fetchAll(PDO::FETCH_OBJ);


            // Generar filas de la tabla con los datos de las categorías
            foreach ($fetch_categorias as $categoria) {?>
            <tr>
                <td><?=$categoria->nombre_categoria?></td>
                <td><a href="../jurados/calificacion_jurados.php"<?=$concurso->id_concurso?> class="btn-bandrank">Seleccionar</a></td>
                
            </tr>

            <?php
            }
            ?>
        </tbody>
    </table>

</body>
</html>