<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Edición de planilla - BandRank</title>
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
                    <h1>Planilla</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Planilla</a></div>
                        <div class="breadcrumb-item">Editar</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Editar planilla</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información a modificar de la planilla</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data" id="form-planilla">
                                        <input type="hidden" name="id_planilla" value="<?=$id?>">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="nombres" class="form-label">Nombre de la planilla <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="nombre_planilla" name="nombre_planilla" required autocomplete="off" value="<?=$datos->nombre_planilla?>">
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label for="correo" class="form-label">Concurso <i class="required">*</i></label>
                                                        <select class="form-control form-control-lg" name="id_concurso" id="id_concurso">
                                                            <option value="">Selecciona una opción</option>
                                                            <?php
                                                            $query = $db->query("SELECT * FROM concurso WHERE eliminado = 0");
                                                            $fetch_concurso = $query->fetchAll(PDO::FETCH_OBJ);

                                                            foreach ($fetch_concurso as $concurso) { ?>
                                                                <option value="<?= $concurso->id_concurso ?>" <?= $datos->id_concurso == $concurso->id_concurso ? 'selected' : '' ?>><?= $concurso->nombre_concurso ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-warning" onclick="editarPlanilla()">Registrar</button>
                                                <a href="../planillas.php" class="btn btn-secondary">Volver</a>
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

    function editarPlanilla() {
        $.ajax({
            url: 'planillaController.php?action=actualizar',
            dataType: 'json',
            type: 'POST',
            data: $('#form-planilla').serialize(),
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
                    title: 'Planilla editada correctamente',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/planilla/planillas.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error al editar la planilla',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/planilla/planillas.php';
                    }
                });
            }
        });
    }
</script>
</body>
</html>