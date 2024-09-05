<?php
include_once('../../../../config.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../../head.php'; ?>
<title>Creación de penalización - BandRank</title>
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php include '../../../../navbar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Penalización</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Penalización</a></div>
                        <div class="breadcrumb-item">Crear</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Crear nueva penalización</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información de la nueva penalización</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="form-penalizacion">
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
                                        <button type="button" class="btn btn-warning" onclick="registrarPenalizacion()">Registrar</button>
                                        <a href="../penalizacion.php" class="btn btn-secondary">Volver</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2023
                <div class="bullet"></div>
            </div>
            <div class="footer-right">
                <?php echo date('d') . ' de ' . date('M') . ' de ' . date('Y');?>
            </div>
        </footer>
    </div>
</div>

<?php include '../../../../footer.php'; ?>
<script>
    function registrarPenalizacion() {
        $.ajax({
            url: '../penalizacionController.php?action=guardar',
            dataType: 'json',
            type: 'POST',
            data: $('#form-penalizacion').serialize(),
            beforeSend: function (){
                Swal.fire({
                    icon: 'info',
                    title: 'Guardando',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            }
        }).done(function(response) {
            if (response.status == 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Penalización creada correctamente',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/penalizacion/penalizacion.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error al crear la penalización',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/penalizacion/penalizacion.php';
                    }
                });
            }
        });
    }

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
</body>
</html>
