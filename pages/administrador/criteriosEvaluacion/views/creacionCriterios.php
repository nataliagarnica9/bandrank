<?php
include_once('../../../../config.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../../head.php'; ?>
<title>Creación de criterios de evaluación - BandRank</title>
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
                    <h1>Criterios</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Criterios</a></div>
                        <div class="breadcrumb-item">Crear</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Crear nuevo criterio de evaluación</h2>
                    <!--<p class="section-lead">
                        Sistema de gestión y evaluación de eventos marciales.
                    </p>-->

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información del nuevo criterio de evaluación</h6>
                                </div>
                                <div class="card-body">
                                    <form id="form_criterios" method="POST">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="nombre_criterio" class="form-label">Nombre del criterio <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="nombre_criterio" name="nombre_criterio" required autocomplete="off">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label for="rango_calificacion" class="form-label">Rango de calificación <i class="required">*</i></label>
                                                <select class="form-control form-control-lg" name="rango_calificacion" id="rango_calificacion" required>
                                                    <option value="5">0 a 5</option>
                                                    <option value="10">0 a 10</option>
                                                    <option value="15">0 a 15</option>
                                                    <option value="20">0 a 20</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="id_planilla" class="form-label">Planilla <i class="required">*</i></label>
                                                <select class="form-control form-control-lg" name="id_planilla" id="id_planilla" required>
                                                    <option value="">Selecciona una opción</option>
                                                    <?php
                                                    $query = $db->query("SELECT id_planilla, nombre_planilla FROM planilla WHERE eliminado = 0");
                                                    $planillas = $query->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($planillas as $planilla) {
                                                        echo '<option value="' . $planilla['id_planilla'] . '">' . $planilla['nombre_planilla'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-warning" onclick="registrarCriterio()">Registrar</button>
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

<?php include '../../../../footer.php'; ?>
<script>
    function registrarCriterio() {
        $.ajax({
            url: '../criteriosController.php?action=guardar',
            dataType: 'json',
            type: 'POST',
            data: $('#form_criterios').serialize(),
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
                    title: 'Criterio de evaluación creado correctamente',
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
                    title: 'Hubo un error al crear el criterio de evaluación',
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