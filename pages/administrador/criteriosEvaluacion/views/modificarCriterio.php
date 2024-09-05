<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Edición de criterio de eval.. - BandRank</title>
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
                    <h1>Criterios de evaluación</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Calificación</a></div>
                        <div class="breadcrumb-item">Editar</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Editar criterio de evaluación</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información a modificar del criterio de evaluación</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data" id="form-criterio">
                                        <input type="hidden" name="id_criterio" value="<?= $id ?>">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="nombre_criterio" class="form-label">Nombre del criterio <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="nombre_criterio" name="nombre_criterio" required autocomplete="off" value="<?=$datos->nombre_criterio ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="rango_calificacion" class="form-label">Rango calificación <i class="required">*</i></label>
                                                <select class="form-control form-control-lg" name="rango_calificacion" id="rango_calificacion">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="5" <?= $datos->rango_calificacion === '5' ? 'selected' : '' ?>>0 a 5</option>
                                                    <option value="10" <?= $datos->rango_calificacion === '10' ? 'selected' : '' ?>>0 a 10</option>
                                                    <option value="15" <?= $datos->rango_calificacion === '15' ? 'selected' : '' ?>>0 a 15</option>
                                                    <option value="20" <?= $datos->rango_calificacion === '20' ? 'selected' : '' ?>>0 a 20</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="id_planilla" class="form-label">Planilla <i class="required">*</i></label>
                                                <select class="form-control form-control-lg" name="id_planilla" id="id_planilla">
                                                    <option value="">Selecciona una opción</option>
                                                    <?php
                                                    $query = $db->query("SELECT * FROM planilla");
                                                    $fetch_planillas = $query->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($fetch_planillas as $planilla) { ?>
                                                        <option value="<?= $planilla->id_planilla ?>" <?= $datos->id_planilla == $planilla->id_planilla ? 'selected' : '' ?>><?= $planilla->nombre_planilla ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning" onclick="editarCriterio()">Guardar cambios</button>
                                        <a href="../criterios.php" class="btn btn-secondary">Volver</a>
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

    function editarCriterio() {
        $.ajax({
            url: 'criteriosController.php?action=actualizar',
            dataType: 'json',
            type: 'POST',
            data: $('#form-criterio').serialize(),
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
                    title: 'Criterio de evaluación editado correctamente',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/criteriosEvaluacion/criterios.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error al editar el criterio',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/criteriosEvaluacion/criterios.php';
                    }
                });
            }
        });
    }
</script>
</body>
</html>