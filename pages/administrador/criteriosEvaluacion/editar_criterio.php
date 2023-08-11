<!doctype html>
<html lang="es">
<head>
<?php require("../../../head.php"); ?>

</head>
<body>
    <?php require("../../../navbar.php");?>

    <div class="container mt-5">
        <?php
        if(isset($_GET['id']) && isset($_GET['criterio'])) {
            $id = $_GET['id'];
            $criterio = $_GET['criterio'];
        } else {
            echo "Parámetros inválidos.";
            exit;
        }
        ?>

        <h3>Editar Criterio</h3>

        <form action="evaluacion_controller.php?action=actualizar_criterio" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="criterio" class="form-label">Criterio</label>
                <input type="text" class="form-control" id="criterio" name="criterio" value="<?php echo $criterio; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        
        <a href="mostrar_criterios.php" class="btn btn-secondary">Volver</a>
    </div>

    <?php require("../../../footer.php"); ?>
</body>
</html>
