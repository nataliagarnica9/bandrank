<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Edición de concurso - BandRank</title>
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
                    <h1>Concursos</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Concursos</a></div>
                        <div class="breadcrumb-item">Editar</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Editar concurso</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información a modificar del concurso</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data" id="form-bandas">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="nombre_banda" class="form-label">Nombre<i class="required">*</i></label>
                                                <input type="hidden" name="id_banda" value="<?= $id?>">
                                                <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" required autocomplete="off" value="<?= $datos["datos"]->nombre?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="ubicacion" class="form-label">Ubicación<i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="ubicacion" name="ubicacion" required autocomplete="off" value="<?= $datos["datos"]->ubicacion?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="id_categoria" class="form-label">Categoría</label>
                                                <select class="form-control form-control-lg" name="id_categoria" id="id_categoria" value="<?= $datos->id_categoria?>">
                                                    <option value="">Selecciona una opción</option>
                                                    <?php
                                                    $query = $db->query("SELECT * FROM categorias_concurso");
                                                    $fetch_categorias_concurso = $query->fetchAll(PDO::FETCH_OBJ);
                                                    foreach($fetch_categorias_concurso as $categorias_concurso) { ?>
                                                        <option value="<?= $categorias_concurso->id_categoria ?>" <?= $datos["datos"]->id_categoria==$categorias_concurso->id_categoria?'selected':''?>><?= $categorias_concurso->nombre_categoria?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="correo" class="form-label">Nombre de Instructor<i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" name="nombre_instructor" id="nombre_instructor" required autocomplete="off" value="<?= $datos["datos"]->nombre_instructor?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="correo_instructor" class="form-label">Correo de Instructor<i class="required">*</i></label>
                                                <input type="email" class="form-control form-control-lg" name="correo_instructor" id="correo_instructor" required autocomplete="off" value="<?= $datos["datos"]->correo_instructor?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="clave" class="form-label">Clave<i class="required">*</i></label>
                                                <input type="password" class="form-control form-control-lg" name="clave" id="clave" required autocomplete="off" value="<?= $datos["datos"]->clave?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="correo" class="form-label">Concurso <i class="required">*</i></label>
                                                <select class="form-control form-control-lg" name="id_concurso" id="id_concurso">
                                                    <option value="">Selecciona una opción</option>
                                                    <?php
                                                    $query = $db->query("SELECT * FROM concurso WHERE eliminado = 0");
                                                    $fetch_concurso = $query->fetchAll(PDO::FETCH_OBJ);
                                                    foreach($fetch_concurso as $concurso) { ?>
                                                        <option value="<?= $concurso->id_concurso ?>" <?= $datos["datos"]->id_concurso==$concurso->id_concurso?'selected':''?>><?= $concurso->nombre_concurso?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <label for="clave" class="form-label">Elección Planilla <i class="required">*</i></label>
                                                <select name="planillas[]" multiple="multiple" class="form-select select_planilla">
                                                    <?php
                                                    $query = $db->query("SELECT * FROM planilla");
                                                    $fetch_planilla = $query->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($fetch_planilla as $planilla) { ?>
                                                        <option value="<?= $planilla->id_planilla ?>" <?php if(in_array($planilla->id_planilla,$datos["planillas"])){echo 'selected';}?>><?= $planilla->nombre_planilla ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-warning" onclick="editarBanda()">Registrar</button>
                                        <a href="bandas.php" class="btn btn-secondary" >Volver</a>
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
    $(document).ready(function() {
        $('.select_planilla').select2({
            width: 'resolve'
        });
    });

    function editarBanda() {
        $.ajax({
            url: 'bandasController.php?action=actualizar',
            dataType: 'json',
            type: 'POST',
            data: $('#form-bandas').serialize(),
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
                    title: 'Banda editada correctamente',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/bandas/bandas.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error al editar la banda',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/bandas/bandas.php';
                    }
                });
            }
        });
    }
</script>
</body>
</html>