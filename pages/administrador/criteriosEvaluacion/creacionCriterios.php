<!DOCTYPE html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>

    <div class="container mt-navbar">
        <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
            <div class="alert-band">
                <i class="fas fa-check" style="color: #00FF00"></i> Criterio creado exitosamente.
            </div>
        <?php endif; ?>

        <h3> Registro de criterio</h3>

        <form action="criterio_controller.php?action=guardar" method="POST">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="nombre_criterio" class="form-label">Nombre del criterio <i class="required">*</i></label>
                    <input type="text" class="form-control form-control-lg" id="nombre_criterio" name="nombre_criterio" required autocomplete="off">
                </div>
                <div class="col-6 mb-3">
                    <label for="rango_calificacion" class="form-label">Rango de calificación <i class="required">*</i></label>
                    <select class="form-control form-control-lg" name="rango_calificacion" id="rango_calificacion" required>
                        <option value="5">0 a 5</option>
                        <option value="10">0 a 10</option>
                        <option value="15">0 a 15</option>
                        <option value="20">0 a 20</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="id_planilla" class="form-label">Planilla <i class="required">*</i></label>
                    <select class="form-control form-control-lg" name="id_planilla" id="id_planilla" required>
                        <option value="">Selecciona una opción</option>
                        <?php
                        $query = $db->query("SELECT id_planilla, nombre_planilla FROM planilla WHERE eliminado = 0");
                        $planillas = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($planillas as $planilla) {
                            echo '<option value="' . $planilla['id_planilla'] . '">' . $planilla['nombre_planilla'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-bandrank">Registrar</button>
            <a href="criteriosMain.php" class="btn">Volver</a>
        </form>
    </div>

    <?php require("../../../footer.php"); ?>
</body>
</html>
