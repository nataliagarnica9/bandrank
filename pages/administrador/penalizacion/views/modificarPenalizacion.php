<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Edición de penalización - BandRank</title>
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php include '../../../navbar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Penalización</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Penalización</a></div>
                        <div class="breadcrumb-item">Editar</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Editar penalización</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información a modificar de la penalización</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data" id="form-penalizacion">
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
                                        <button type="button" class="btn btn-warning" onclick="editarPenalizacion()">Guardar cambios</button>
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

<?php include '../../../footer.php'; ?>
<script>

    function editarPenalizacion() {
        $.ajax({
            url: 'penalizacionController.php?action=actualizar',
            dataType: 'json',
            type: 'POST',
            data: $('#form-penalizacion').serialize(),
            beforeSend: function (){
                Swal.fire({
                    icon: 'info',
                    title: 'Editando',
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
                    title: 'Penalización editada correctamente',
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
                    title: 'Hubo un error al editar la penalización',
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
</body>
</html>