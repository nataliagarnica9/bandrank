<!DOCTYPE html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>

    <div class="container mt-navbar">
        <?php if (isset($status) && $status == 'success') : ?>
            <div class="alert-band">
                <i class="fas fa-check" style="color: #00FF00"></i> Planilla creada exitosamente.
            </div>
        <?php endif; ?>

        <h3>Registro de planilla</h3>

        <form action="planilla_controller.php?action=guardar" method="POST">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="nombre_planilla" class="form-label">Nombre de la planilla <i class="required">*</i></label>
                    <input type="text" class="form-control form-control-lg" id="nombre_planilla" name="nombre_planilla" required autocomplete="off">
                </div>
                <div class="col-6 mb-3">
                    <label for="id_concurso" class="form-label">Concurso <i class="required">*</i></label>
                    <select class="form-control form-control-lg" name="id_concurso" id="id_concurso" required>
                        <option value="">Selecciona una opción</option>
                        <?php
                        $query = $db->query("SELECT id_concurso, nombre_concurso FROM concurso");
                        $concursos = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($concursos as $concurso) {
                            echo '<option value="' . $concurso['id_concurso'] . '">' . $concurso['nombre_concurso'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-bandrank">Registrar</button>
            <a href="planillaMain.php" class="btn">Volver</a>
        </form>
    </div>

    <?php require("../../../footer.php"); ?>
</body>
</html>
