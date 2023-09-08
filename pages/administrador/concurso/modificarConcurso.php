<div class="container mt-navbar">
    <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
        <div class="alert-band">
            <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
            <a href="concursos.php" class="btn">Aceptar</a>
        </div>
    <?php elseif (isset($_REQUEST["message_error"])) : ?>
        <div class="alert-band">
            <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
            <?php echo $_REQUEST["message_error"]; ?>
            <a href="concursos.php" class="btn">Aceptar</a>
        </div>  
    <?php endif; ?>

    <h3>Editar concurso</h3>

    <form action="concurso_controller.php?action=actualizar" method="POST" enctype="multipart/form-data" id="form-concurso">
        <input type="hidden" name="id_concurso" value="<?= $id ?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="nombre_concurso" class="form-label">Nombre del concurso <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="nombre_concurso" name="nombre_concurso" required autocomplete="off" value="<?= $datos["datos"]->nombre_concurso ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="ubicacion" class="form-label">Ubicación <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="ubicacion" name="ubicacion" required autocomplete="off" value="<?= $datos["datos"]->ubicacion ?>">
            </div>
            <div class="col-6 mb-3">
                <label for="director" class="form-label">Director <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="director" name="director" required autocomplete="off" value="<?= $datos["datos"]->director ?>">
            </div>
        </div>
        <div class="row">
        <div class="col-6 mb-3">
                <label for="fecha_evento" class="form-label">Fecha del evento <i class="required">*</i></label>
                <input type="date" class="form-control form-control-lg" id="fecha_evento" name="fecha_evento" required value="<?= $datos["datos"]->fecha_evento ?>">
        </div>
    </div>
        <div class="row">
            <div class="col-12 mb-2">
                <label for="categoria" class="form-label">Categorias <i class="required">*</i></label>
                <select name="categorias[]" multiple="multiple" class="form-select select_categoria">
                <?php
                    $query = $db->query("SELECT * FROM categorias_concurso WHERE eliminado = 0");
                    $fetch_cat = $query->fetchAll(PDO::FETCH_OBJ);

                    foreach ($fetch_cat as $categoria) { ?>
                        <option value="<?= $categoria->id_categoria ?>" <?php if(in_array($categoria->id_categoria,$datos["categorias"])){echo 'selected';}?>><?= $categoria->nombre_categoria ?></option>
                    <?php
                    }
                ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn-bandrank">Guardar Cambios</button>
        <a href="concursos.php" class="btn">Volver</a>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.select_categoria').select2({
            width: 'resolve'
        });
    });
</script>