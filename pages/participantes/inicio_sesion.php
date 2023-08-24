<!doctype html>
<html lang="es">
<?php require("../../head.php"); ?>

<style>
    <?php require("../../dist/css/login.css"); ?>
</style>

<body>

    <section>
        <div class="content animate__animated animate__fadeIn">
            <div class="left">
                <img src="../../dist/images/bandrank_isotipo_blanco.png" alt="icon">
            </div>
            <div class="right">
                <div class="title">
                    <h2>Bienvenido a Bandrank</h2>

                    <div class="alerta alerta-success shadow-sm" style="display: none;">
                        <div class="row">
                            <div class="col-1">
                            <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="col-11">
                                <b class="titulo">Todo salió bien</b>
                                <br>
                                <p class="mensaje">Iniciando sesión</p>
                            </div>
                        </div>
                    </div>

                    <div class="alerta alerta-error shadow-sm" >
                        <div class="row">
                            <div class="col-1">
                            <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="col-11">
                                <b class="titulo">Todo salió bien</b>
                                <br>
                                <p class="mensaje">Iniciando sesión</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form">
                    <form id="form-inicio-sesion" method="POST" enctype="multipart/form-data">
                        <div class="inputbox">
                            <label>Correo electrónico</label>
                            <input type="email" class="form-control" name="correo" required>
                        </div>
                        <div class="inputbox">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="clave" required>
                        </div>
                        <div class="create">
                            <button type="submit">Iniciar sesión</button>
                        </div>
                        <div class="or">
                            <div class="sign">
                                <a href="../../inicio.php" class="button">
                                    <span>Regresar</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <?php require("../../footer.php"); ?>
    <script>
        function ingresar() {
            $.ajax({
                url: 'autenticacion.php?type=login',
                dataType: 'json',
                type: 'POST',
                data: $('#form-inicio-sesion').serialize()
            }).done(function(response) {
                if (response.status == 'success') {
                    location.reload();
                } else {
                    console.log('error');
                }
            });
        }
    </script>
</body>
<?php require("../../footer.php"); ?>
</html>