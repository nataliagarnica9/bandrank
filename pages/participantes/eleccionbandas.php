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
            $categorias = $db->prepare("select * from banda where id_categoria = ?");
            $categorias->bindValue(1,$_REQUEST["categoria"]);
            $categorias->execute();
            $fetch_categorias = $categorias->fetchAll(PDO::FETCH_OBJ);


            // Generar filas de la tabla con los datos de las categorías
            foreach ($fetch_categorias as $categoria) {?>
            <tr>
                <td><?=$categoria->nombre?></td>
                <td><a href="../participantes/jurados/calificacion_jurados.php"<?=$concurso->id_concurso?> class="btn-bandrank">Seleccionar</a></td>
                
            </tr>

            <?php
            }
            ?>
        </tbody>
    </table>

</body>
</html>