<!DOCTYPE html>
<html lang="es">
    <?php require("../../../head.php"); ?>
<body>
<?php require("../../../navbar.php");?>

<div class="container mt-navbar">
    <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success'): ?>
        <div class="alert-band">
            <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
            <a href="jurados.php" class="btn">Aceptar</a>
        </div>
    <?php elseif(isset($_REQUEST["message_error"])): ?>
        <div class="alert-band">
            <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
            <?php echo $_REQUEST["message_error"]; ?>
            <a href="jurados.php" class="btn">Aceptar</a>
        </div>
    <?php endif; ?>

    <form action="jurado_controller.php?action=guardar" method="POST" enctype="multipart/form-data">
        <!-- ... (código del formulario) ... -->
    </form>

    <h3> Elija el concurso</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Concurso</th>
                <th>Opción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Datos de ejemplo de concursos
            $concurso = $db->prepare("select * from concurso where eliminado = 0");
            $concurso->execute();
            $fetch_concursos = $concurso->fetchAll(PDO::FETCH_OBJ);

            // Generar filas de la tabla con los datos de los concursos
            foreach ($fetch_concursos as $concurso) {?>
            <tr>
                <td><?=$concurso->nombre_concurso?></td>
                <td><a href="../jurados/Categorias.php?concurso=<?=$concurso->id_concurso?>" class="btn-bandrank">Seleccionar</a></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</body>
</html>
