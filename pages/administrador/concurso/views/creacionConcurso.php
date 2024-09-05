<?php
include_once('../../../../config.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../../head.php'; ?>
<title>Creación de concursos - BandRank</title>
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
                    <h1>Concursos</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Concursos</a></div>
                        <div class="breadcrumb-item">Crear</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Crear nuevo concurso</h2>
                    <!--<p class="section-lead">
                        Sistema de gestión y evaluación de eventos marciales.
                    </p>-->

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información del nuevo concurso</h6>
                                </div>
                                <div class="card-body">
                                    <form id="form_concurso" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="nombre_concurso" class="form-label">Nombre del concurso <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="nombre_concurso" name="nombre_concurso" required autocomplete="off">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label for="director" class="form-label">Director <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="director" name="director" required autocomplete="off">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label for="ubicacion" class="form-label">Dirección / Ubicación <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="ubicacion" name="ubicacion" required autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="fecha_evento" class="form-label">Fecha del evento</label>
                                                <input type="date" class="form-control form-control-lg" id="fecha_evento" name="fecha_evento"  maxlength="10" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <label for="categoria" class="form-label">Categorias <i class="required">*</i></label>
                                                <select name="categorias[]" multiple="multiple" class="form-select select_categoria">
                                                    <?php
                                                    $query = $db->query("SELECT * FROM categorias_concurso WHERE eliminado = 0");
                                                    $fetch_cat = $query->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($fetch_cat as $categoria) { ?>
                                                        <option value="<?= $categoria->id_categoria ?>"><?= $categoria->nombre_categoria ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning" onclick="registrarConcurso()">Registrar</button>
                                        <a href="<?=base_url?>pages/administrador/concurso/concursos.php" type="button" class="btn btn-light">Volver</a>
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
    $(document).ready(function() {
        $('.select_categoria').select2({
            width: 'resolve'
        });
    });

    function registrarConcurso() {
        $.ajax({
            url: '../concursoController.php?action=save',
            dataType: 'json',
            type: 'POST',
            data: $('#form_concurso').serialize(),
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
                    title: 'Concurso creado correctamente',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/concurso/concursos.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error al crear un concurso',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/concurso/concursos.php';
                    }
                });
            }
        });
    }
</script>
</body>
</html>