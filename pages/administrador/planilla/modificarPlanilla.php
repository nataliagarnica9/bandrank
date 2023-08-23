<div class="container mt-navbar">
    <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
        <div class="alert-band">
            <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
            <a href="planillaMain.php" class="btn">Aceptar</a>
        </div>
    <?php elseif (isset($_REQUEST["message_error"])) : ?>
        <div class="alert-band">
            <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
            <?php echo $_REQUEST["message_error"]; ?>
            <a href="planillaMain.php" class="btn">Aceptar</a>
        </div>
    <?php endif; ?>

    <h3> Editar planilla</h3>

    <form action="planilla_controller.php?action=actualizar" method="POST" enctype="multipart/form-data" id="form-planilla">
        <input type="hidden" name="id_planilla" value="<?=$id?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="nombres" class="form-label">Nombre de la planilla <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="nombre_planilla" name="nombre_planilla" required autocomplete="off" value="<?=$datos->nombre_planilla?>">
        <div class="row">
            <div class="col-12 mb-3">
                <label for="correo" class="form-label">Concurso <i class="required">*</i></label>
                <select class="form-control form-control-lg" name="id_concurso" id="id_concurso">
                    <option value="">Selecciona una opción</option>
                    <?php
                    $query = $db->query("SELECT * FROM concurso");
                    $fetch_concurso = $query->fetchAll(PDO::FETCH_OBJ);

                    foreach ($fetch_concurso as $concurso) { ?>
                        <option value="<?= $concurso->id_concurso ?>" <?= $datos->id_concurso == $concurso->id_concurso ? 'selected' : '' ?>><?= $concurso->nombre_concurso ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn-bandrank">Registrar</button>
        <a href="planillaMain.php" class="btn">Volver</a>
    </form>
</div>