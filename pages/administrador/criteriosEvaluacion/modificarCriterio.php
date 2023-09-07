<div class="container mt-navbar">
    <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
        <div class="alert-band">
            <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
            <a href="criterioMain.php" class="btn">Aceptar</a>
        </div>
    <?php elseif (isset($_REQUEST["message_error"])) : ?>
        <div class="alert-band">
            <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
            <?php echo $_REQUEST["message_error"]; ?>
            <a href="criteriosMain.php" class="btn">Aceptar</a>
        </div>
    <?php endif; ?>

    <h3>Editar criterio</h3>

    <form action="criterio_controller.php?action=actualizar" method="POST" enctype="multipart/form-data" id="form-criterio">
        <input type="hidden" name="id_criterio" value="<?= $id ?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="nombre_criterio" class="form-label">Nombre del criterio <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="nombre_criterio" name="nombre_criterio" required autocomplete="off" value="<?=$datos->nombre_criterio ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="rango_calificacion" class="form-label">Rango calificación <i class="required">*</i></label>
                <select class="form-control form-control-lg" name="rango_calificacion" id="rango_calificacion">
                    <option value="">Selecciona una opción</option>
                    <option value="5" <?= $datos->rango_calificacion === '5' ? 'selected' : '' ?>>0 a 5</option>
                    <option value="10" <?= $datos->rango_calificacion === '10' ? 'selected' : '' ?>>0 a 10</option>
                    <option value="15" <?= $datos->rango_calificacion === '15' ? 'selected' : '' ?>>0 a 15</option>
                    <option value="20" <?= $datos->rango_calificacion === '20' ? 'selected' : '' ?>>0 a 20</option>
                </select>
            </div>
        </div>
        <div class="row">
    <div class="col-12 mb-3">
        <label for="id_planilla" class="form-label">Planilla <i class="required">*</i></label>
        <select class="form-control form-control-lg" name="id_planilla" id="id_planilla">
            <option value="">Selecciona una opción</option>
            <?php
            $query = $db->query("SELECT * FROM planilla");
            $fetch_planillas = $query->fetchAll(PDO::FETCH_OBJ);

            foreach ($fetch_planillas as $planilla) { ?>
                <option value="<?= $planilla->id_planilla ?>" <?= $datos->id_planilla == $planilla->id_planilla ? 'selected' : '' ?>><?= $planilla->nombre_planilla ?></option>
            <?php
            }
            ?>
        </select>
    </div>
</div>

        <button type="submit" class="btn-bandrank">Guardar Cambios</button>
        <a href="criteriosMain.php" class="btn">Volver</a>
    </form>
</div>
