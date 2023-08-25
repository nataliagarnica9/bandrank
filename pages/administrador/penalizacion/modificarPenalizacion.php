<div class="container mt-navbar">
    <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
        <div class="alert-band">
            <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
            <a href="penalizacionMain.php" class="btn">Aceptar</a>
        </div>
    <?php elseif (isset($_REQUEST["message_error"])) : ?>
        <div class="alert-band">
            <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
            <?php echo $_REQUEST["message_error"]; ?>
            <a href="penalizacionMain.php" class="btn">Aceptar</a>
        </div>
    <?php endif; ?>

    <h3>Editar penalización</h3>

    <form action="penalizacion_controller.php?action=actualizar" method="POST" enctype="multipart/form-data" id="form-penalizacion">
        <input type="hidden" name="id_penalizacion" value="<?= $id ?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="descripcion_penalizacion" class="form-label">Descripción de la penalización <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="descripcion_penalizacion" name="descripcion_penalizacion" required autocomplete="off" value="<?= $datos->descripcion_penalizacion ?>">
            </div>
            <div class="col-6 mb-3">
                <label for="tipo_penalizacion" class="form-label">Tipo de penalización <i class="required">*</i></label>
                <select class="form-control form-control-lg" name="tipo_penalizacion" id="tipo_penalizacion" onchange="handleTipoPenalizacionChange()" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Resta" <?= $datos->tipo_penalizacion === 'Resta' ? 'selected' : '' ?>>Resta</option>
                    <option value="Descalificación" <?= $datos->tipo_penalizacion === 'Descalificación' ? 'selected' : '' ?>>Descalificación</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="puntaje_penalizacion" class="form-label">Puntaje de penalización (ingresar el valor positivo) <i class="required">*</i></label>
                <input type="number" class="form-control form-control-lg" id="puntaje_penalizacion" name="puntaje_penalizacion" required value="<?= $datos->puntaje_penalizacion ?>" <?= $datos->tipo_penalizacion === 'Descalificación' ? 'readonly' : '' ?>>
            </div>
        </div>
        <button type="submit" class="btn-bandrank">Guardar Cambios</button>
        <a href="penalizacionMain.php" class="btn">Volver</a>
    </form>
</div>

<script>
    function handleTipoPenalizacionChange() {
        const tipoPenalizacion = document.getElementById('tipo_penalizacion').value;
        const puntajePenalizacion = document.getElementById('puntaje_penalizacion');
        
        if (tipoPenalizacion === 'Descalificación') {
            puntajePenalizacion.value = '0';
            puntajePenalizacion.setAttribute('readonly', 'readonly');
        } else {
            puntajePenalizacion.removeAttribute('readonly');
        }
    }
    
</script>
