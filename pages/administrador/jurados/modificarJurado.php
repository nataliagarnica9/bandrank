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

    <h3> Editar jurado</h3>

    <form action="jurado_controller.php?action=actualizar" method="POST" enctype="multipart/form-data" id="form-jurado">
        <input type="hidden" name="id_jurado" value="<?=$id?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="nombres" class="form-label">Nombres <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="nombres" name="nombres" required autocomplete="off" value="<?=$datos["datos"]->nombres?>">
            </div>
            <div class="col-6 mb-3">
                <label for="apellidos" class="form-label">Apellidos <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="apellidos" name="apellidos" required autocomplete="off" value="<?=$datos["datos"]->apellidos?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="documento_identificacion" class="form-label">Documento de identificación <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="documento_identificacion" name="documento_identificacion" required autocomplete="off" value="<?=$datos["datos"]->documento_identificacion?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="celular" class="form-label">Celular</label>
                <input type="number" class="form-control form-control-lg" id="celular" name="celular" maxlength="10" autocomplete="off" value="<?=$datos["datos"]->celular?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="correo" class="form-label">Correo electrónico <i class="required">*</i></label>
                <input type="email" class="form-control form-control-lg" name="correo" id="correo" required value="<?=$datos["datos"]->correo?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label for="clave" class="form-label">Contraseña </label>
                <small style="color:#BFC9CA;">Si no vas a modificar la clave, deja este campo vacío.</small>
                <input type="password" class="form-control form-control-lg" name="clave" id="clave">
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
                        <option value="<?= $concurso->id_concurso ?>" <?= $datos["datos"]->id_concurso == $concurso->id_concurso ? 'selected' : '' ?>><?= $concurso->nombre_concurso ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 mb-2">
                <label for="clave" class="form-label">Elección Planilla <i class="required">*</i></label>
                <select name="planillas[]" multiple="multiple" class="form-select select_planilla">
                <?php
                    $query = $db->query("SELECT * FROM planilla");
                    $fetch_planilla = $query->fetchAll(PDO::FETCH_OBJ);

                    foreach ($fetch_planilla as $planilla) { ?>
                        <option value="<?= $planilla->id_planilla ?>" <?php if(in_array($planilla->id_planilla,$datos["planillas"])){echo 'selected';}?>><?= $planilla->nombre_planilla ?></option>
                    <?php
                    }
                ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3">
                <div class="mb-3">
                    <label for="firma" class="form-label">Firma </label>
                    <small style="color:#BFC9CA;">Si no vas a modificar la firma, deja este campo vacío.</small>
                    <input class="form-control" type="file" id="firma" name="firma">
                    </div>
            </div>
        </div>

        <button type="submit" class="btn-bandrank">Registrar</button>
        <a href="<?=base_url?>pages/administrador/inicio.php" type="button" class="btn btn-light">Volver</a>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.select_planilla').select2({
            width: 'resolve'
        });
    });
</script>