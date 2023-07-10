<!doctype html>
<html lang="es">
    <?php require("../../head.php"); ?>
<body>
<?php require("../../navbar.php");?>

<div class="container mt-5">
    <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success'): ?>
            <div class="alert-band">
                <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
                <a href="jurados.php" class="btn">Aceptar</a>
            </div>
    <?php elseif(isset($_REQUEST["message_error"])): ?>
            <div class="alert-band">
                <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
                <?php echo $_REQUEST["message_error"]; ?>
                <a href="jurados.php" class="btn">Aceptar</a>
            </div>
    <?php endif; ?>

    <h3> Registro de jurado</h3>

    <form action="jurado_controller.php?action=guardar" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-3 mb-3">
                <label for="nombres" class="form-label">Nombres <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="nombres" name="nombres" required autocomplete="off">
            </div>
            <div class="col-3 mb-3">
                <label for="apellidos" class="form-label">Apellidos <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="apellidos" name="apellidos" required autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="documento_identificacion" class="form-label">Documento de identificación <i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="documento_identificacion" name="documento_identificacion" required autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="celular" class="form-label">Celular</label>
                <input type="number" class="form-control form-control-lg" id="celular" name="celular"  maxlength="10" autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label for="correo" class="form-label">Correo electrónico <i class="required">*</i></label>
                <input type="email" class="form-control form-control-lg" name="correo" id="correo" required>
            </div>
        </div>

        <button type="submit" class="btn-bandrank">Registrar</button>
    </form>

</div>

</body>
    <!--<script type="text/javascript">
        $('#creacion_jurado').on('submit', function() {
            $.ajax({
                url: 'jurado_controller.php?action=guardar',
                type: 'POST',
                dataType: 'JSON',
                data: $('#creacion_jurado').serialize(),
                success: function (data) {
                    if(data.status){}
                }
            });
        }
    </script>-->
</html>