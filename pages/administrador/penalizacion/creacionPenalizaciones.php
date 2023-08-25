<!DOCTYPE html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>

    <div class="container mt-navbar">
        <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
            <div class="alert-band">
                <i class="fas fa-check" style="color: #00FF00"></i> Penalización creada exitosamente.
            </div>
        <?php endif; ?>

        <h3> Registro de penalización</h3>

        <form action="penalizacion_controller.php?action=guardar" method="POST">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="descripcion_penalizacion" class="form-label">Descripción de la penalización <i class="required">*</i></label>
                    <input type="text" class="form-control form-control-lg" id="descripcion_penalizacion" name="descripcion_penalizacion" required autocomplete="off">
                </div>
                <div class="col-6 mb-3">
                    <label for="tipo_penalizacion" class="form-label">Tipo de penalización <i class="required">*</i></label>
                    <select class="form-control form-control-lg" id="tipo_penalizacion" name="tipo_penalizacion" required onchange="handleTipoPenalizacionChange()">
                        <option value="">Selecciona una opción</option>
                        <option value="Resta">Resta</option>
                        <option value="Descalificación">Descalificación</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="puntaje_penalizacion" class="form-label">Puntaje de penalización (ingresar el valor positivo) <i class="required">*</i></label>
                    <input type="number" class="form-control form-control-lg" id="puntaje_penalizacion" name="puntaje_penalizacion" required>
                </div>
                <div class="col-6 mb-3">
                </div>
            </div>
            <button type="submit" class="btn-bandrank">Registrar</button>
            <a href="penalizacionMain.php" class="btn">Volver</a>
        </form>
    </div>

    <script>
        function handleTipoPenalizacionChange() {
            var tipoPenalizacionSelect = document.getElementById("tipo_penalizacion");
            var puntajePenalizacionInput = document.getElementById("puntaje_penalizacion");

            if (tipoPenalizacionSelect.value === "Descalificación") {
                puntajePenalizacionInput.value = 0;
                puntajePenalizacionInput.disabled = true;
            } else {
                puntajePenalizacionInput.disabled = false;
            }
        }
    </script>

    <?php require("../../../footer.php"); ?>
</body>
</html>
