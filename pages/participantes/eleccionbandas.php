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
            $banda = $db->prepare("select * from banda where clave = ?");
            $banda->bindValue(1,$_REQUEST["banda"]);
            $banda->execute();
            $fetch_banda = $banda->fetchAll(PDO::FETCH_OBJ);


            // Generar filas de la tabla con los datos de las categorías
            foreach ($fetch_banda as $banda) {?>
            <tr>
                <td><?=$banda->nombre?></td>
                <td><a href="../eleccionbandas.php?banda=<?=$_REQUEST['banda']?>&banda=<?=$banda->nombre?>" class="btn-bandrank">Seleccionar</a></td>
                
            </tr>

            <?php
            }
            ?>
        </tbody>
    </table>

</body>
</html>