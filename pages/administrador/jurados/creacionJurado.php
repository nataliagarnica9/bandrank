<div class="container mt-navbar">
    <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
        <div class="alert-band">
            <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
            <a href="jurados.php" class="btn">Aceptar</a>
        </div>
    <?php elseif (isset($_REQUEST["message_error"])) : ?>
        <div class="alert-band">
            <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
            <?php echo $_REQUEST["message_error"]; ?>
            <a href="jurados.php" class="btn">Aceptar</a>
        </div>
    <?php endif; ?>

    <h3> Registro de jurado</h3>

    <form action="jurado_controller.php?action=guardar" method="POST" enctype="multipart/form-data" id="form-jurado">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="nombres" class="form-label">Nombres <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="nombres" name="nombres" required autocomplete="off">
            </div>
            <div class="col-6 mb-3">
                <label for="apellidos" class="form-label">Apellidos <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="apellidos" name="apellidos" required autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="documento_identificacion" class="form-label">Documento de identificación <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="documento_identificacion" name="documento_identificacion" required autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="celular" class="form-label">Celular</label>
                <input type="number" class="form-control form-control-lg" id="celular" name="celular" maxlength="10" autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="correo" class="form-label">Correo electrónico <i class="required">*</i></label>
                <input type="email" class="form-control form-control-lg" name="correo" id="correo" required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="clave" class="form-label">Contraseña <i class="required">*</i></label>
                <input type="password" class="form-control form-control-lg" name="clave" id="clave" required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="correo" class="form-label">Concurso <i class="required">*</i></label>
                <select class="form-control form-control-lg" name="concurso" id="concurso">
                    <option value="">Selecciona una opción</option>
                    <?php
                    $query = $db->query("SELECT * FROM concurso");
                    $fetch_concurso = $query->fetchAll(PDO::FETCH_OBJ);

                    foreach ($fetch_concurso as $concurso) { ?>
                        <option value="<?= $concurso->id_concurso ?>"><?= $concurso->nombre_concurso ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-12 mb-2">
        <label for="clave" class="form-label">Elección Planilla <i class="required">*</i></label>
        <br>
            <form action="Jurado.php" method="POST">
                <select name="planillas[]" multiple="multiple">
                    <option value="Planilla 1">Planilla 1</option>
                    <option value="Planilla 2">Planilla 2</option>
                    <option value="Planilla 3">Planilla 3</option>
                    <option value="Planilla 4">Planilla 4</option>
                </select>
                    <br>
                    <label for="op1">
                        <input type="checkbox" id="op1" name="tipoplanilla" value="Calificacion1">
                        Calificacion1
                    </label>
                    <label for="op2">
                        <input type="checkbox" id="op2" name="tipoplanilla" value="Calificacion2">
                        Calificacion2
                    </label>
                    <label for="op3">
                        <input type="checkbox" id="op3" name="tipoplanilla" value="Calificacion3">
                        Calificacion3
                    </label>
            </form>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <div class="mb-3">
                <label for="firma" class="form-label">Firma </label>
                    <input class="form-control" type="file" id="firma" name="firma">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-bandrank">Registrar</button>
    </form>
</div>