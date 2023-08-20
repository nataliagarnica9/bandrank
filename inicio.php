<!DOCTYPE html>
<html lang="en">
<?php require("head.php"); ?>

<body>
    <div class="bloque-inicial">
        <img src="<?=base_url?>dist/images/bandrank_isotipo.png"
            class="img-inicio animate__animated animate__backInDown">
        <h1 class="animate__animated animate__backInDown">Bienvenido</h1>
        <p class="animate__animated animate__backInUp">
            ¿A dónde deseas ingresar?
        </p>
        <a class="btn-bandrank animate__animated animate__backInUp" data-bs-toggle="modal" data-bs-target="#modal_autenticacion">Administrador</a>
        <a href="<?= base_url ?>pages/participantes/inicio.php"
            class="btn-bandrank animate__animated animate__backInUp">Participante</a>
            <br><br>
        <a href="<?= base_url ?>pages/puntuaciones.php"
            class="btn-bandrank animate__animated animate__backInUp">Ver puntuación en tiempo real</a>
    </div>
    <!--href="<?= base_url ?>pages/administrador/inicio.php"-->

    <!-- Modal -->
    <div class="modal fade" id="modal_autenticacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Autenticación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert-band" id="alert-band" style="display: none;">
                        <i class="fas fa-times" style="color:red;"></i> Autenticación de administrador incorrecta. Intenta de nuevo. <br>
                    </div>
                    <div class="mb-3">
                        <label for="clave_admin" class="form-label">Ingresa clave de administrador</label>
                        <input type="password" class="form-control" id="clave_admin">
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-bandrank" onclick="comprobarAdministrador()">Comprobar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<?php require("footer.php"); ?>
<script>
    function comprobarAdministrador() {
        let vlr_autenticacion = $('#clave_admin').val();
        $.ajax({
            url: 'autenticacion.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'vlr_autenticacion': vlr_autenticacion
            }
        }).done(function(result){
            if(result.status == 'success') {
                location.href = 'pages/administrador/inicio.php';
            } else if(result.status == 'error') {
                $('#alert-band').css('width','100%');
                $('#alert-band').css('display','block');
                $('#alert-band').css('color','red');
            } else {
                $('#alert-band').css('display','block');
            }
        })
    }
</script>
</html>