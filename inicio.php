<?php
require "config.php";
// realizo la destrucción de la sesión para evitar cruces de información
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Inicio Bandrank</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Template CSS -->
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/components.css">
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="<?= base_url ?>dist/images/bandrank_isotipo.png" alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Inicio de sesión</h4></div>

                        <div class="alerta shadow-sm" id="alerta-success" style="display: none;">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fas fa-check-circle" style="color: #32CD32;"></i>
                                </div>
                                <div class="col-11">
                                    <b class="titulo">Todo salió bien</b>
                                </div>
                            </div>
                        </div>

                        <div class="alerta shadow-sm" id="alerta-error" style="display: none;">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fas fa-exclamation-circle" style="color: #FF4500;"></i>
                                </div>
                                <div class="col-11">
                                    <b class="titulo">No se pudo iniciar sesión</b>
                                    <br>
                                    <div id="mensaje"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="POST" class="needs-validation" id="form-inicio-sesion">

                                <div class="form-group">
                                    <label for="tipo_usuario">Rol</label>
                                    <select name="tipo" id="tipo" class="form-control" onchange="validarRol()" required>
                                        <option value="">Selecciona una opción</option>
                                        <option value="administrador">Administrador</option>
                                        <option value="instructor">Instructor</option>
                                        <option value="jurado">Jurado</option>
                                    </select>
                                    <div class="invalid-feedback" id="valida-correo">
                                        Por favor selecciona tu rol
                                    </div>
                                </div>

                                <div class="form-group" id="correo">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                        Por favor escribe tu correo
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Contraseña</label>
                                        <div class="float-right">
                                            <a href="auth-forgot-password.html" class="text-small">
                                                Olvidaste tu contraseña?
                                            </a>
                                        </div>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa tu contraseña
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-lg btn-block" tabindex="4" onclick="ingresar()">
                                        Ingresar
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Quieres saber más sobre nosotros? <a href="https://bandrank.com.co/es/" target="_blank">Haz clic aquí</a>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; BandRank <?= date('Y') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- General JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="dist/js/stisla.js"></script>


<!-- Template JS File -->
<script src="dist/js/scripts.js"></script>
<script src="dist/js/custom.js"></script>
<script>

    function validarRol() {
        let tipo_usuario = $('#tipo').val();
        if(tipo_usuario == 'administrador') {
            $('#correo').css('display', 'none');
        } else {
            $('#correo').css('display', 'block');
        }
    }

    function ingresar() {
        $('#alerta-success').css('display','none');
        $('#alerta-error').css('display','none');

        let tipo_usuario = $('#tipo').val();

        if(tipo_usuario == "") {
            $('#valida-correo').show();
        } else {
            $.ajax({
                url: 'autenticacion.php',
                dataType: 'json',
                type: 'POST',
                data: $('#form-inicio-sesion').serialize()
            }).done(function(response) {
                if (response.status == 'success') {
                    $('#alerta-success').css('display','block');
                    setTimeout(function () {
                        if(response.rol == 'admin') {
                            location.href = 'pages/administrador/inicio.php';
                        } else if(response.rol == 'participante') {
                            location.href = 'pages/participantes/inicio.php';
                        }
                    },500);
                } else {
                    $('#mensaje').text(response.message);
                    $('#alerta-error').css('display','block');
                }
            });
        }
    }

</script>
</body>
</html>




















<!--<!DOCTYPE html>
<html lang="en">


<body>
    <div class="bloque-inicial">
        <img src="<?= base_url ?>dist/images/bandrank_isotipo.png" class="img-inicio animate__animated animate__backInDown">
        <h1 class="animate__animated animate__backInDown">Bienvenido</h1>
        <p class="animate__animated animate__backInUp">
            Ingresar como:
        </p>
        <form action="post" id="form-login">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-4">&nbsp;</div>
                <div class="col-12 col-md-3">
                    <select name="tipo_usuario" id="tipo_usuario" class="form-select animate__animated animate__backInUp">
                        <option value="">Selecciona una opción</option>
                        <option value="administrador">Administrador</option>
                        <option value="instructor">Instructor</option>
                        <option value="jurado">Jurado</option>
                    </select>
                </div>
                <div class="col-12 col-md-1">
                    <a class="btn-bandrank animate__animated animate__backInUp" onclick="iniciar_sesion()">Ingresar</a>
                </div>
                <div class="col-4">&nbsp;</div>
            </div>


        </form>
    </div>-->

    <!-- Modal -->
    <!--<div class="modal fade" id="modal_autenticacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<?php //require("footer.php"); ?>
<script>

    function iniciar_sesion() {
        let tipo_usuario = $('#tipo_usuario').val();
        if(tipo_usuario == 'administrador') {
            $('#modal_autenticacion').modal('show');
            localStorage.setItem('rol','admin');
            $(document).keyup(function(event) {
            if (event.which === 13) {
                iniciar_sesion();
            }
            });
        } else {
            location.href = 'pages/participantes/inicio_sesion.php';
        }
    }

    function comprobarAdministrador() {
        let vlr_autenticacion = $('#clave_admin').val();
        $.ajax({
            url: 'autenticacion.php?type=admin',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'vlr_autenticacion': vlr_autenticacion
            }
        }).done(function(result) {
            if (result.status == 'success') {
                location.href = 'pages/administrador/inicio.php';
            } else if (result.status == 'error') {
                $('#alert-band').css('width', '100%');
                $('#alert-band').css('display', 'block');
                $('#alert-band').css('color', 'red');
            } else {
                $('#alert-band').css('display', 'block');
            }
        })
    }
    
</script>

</html>-->