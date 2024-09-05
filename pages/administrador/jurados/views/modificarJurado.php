<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Edición de jurado - BandRank</title>
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
                    <h1>Jurados</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Jurados</a></div>
                        <div class="breadcrumb-item">Editar</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Editar jurado</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información a modificar del jurado</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data" id="form-jurado">
                                        <input type="hidden" name="id_jurado" value="<?= $id ?>">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="nombres" class="form-label">Nombres <i
                                                            class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="nombres"
                                                       name="nombres" required autocomplete="off"
                                                       value="<?= $datos["datos"]->nombres ?>">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label for="apellidos" class="form-label">Apellidos <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="apellidos"
                                                       name="apellidos" required autocomplete="off"
                                                       value="<?= $datos["datos"]->apellidos ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="documento_identificacion" class="form-label">Documento de
                                                    identificación <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg"
                                                       id="documento_identificacion" name="documento_identificacion"
                                                       required autocomplete="off"
                                                       value="<?= $datos["datos"]->documento_identificacion ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="celular" class="form-label">Celular</label>
                                                <input type="number" class="form-control form-control-lg" id="celular"
                                                       name="celular" maxlength="10" autocomplete="off"
                                                       value="<?= $datos["datos"]->celular ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="correo" class="form-label">Correo electrónico <i
                                                            class="required">*</i></label>
                                                <input type="email" class="form-control form-control-lg" name="correo"
                                                       id="correo" required value="<?= $datos["datos"]->correo ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="clave" class="form-label">Contraseña </label>
                                                <small style="color:#BFC9CA;">Si no vas a modificar la clave, deja este
                                                    campo vacío.</small>
                                                <input type="password" class="form-control form-control-lg" name="clave"
                                                       id="clave">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="correo" class="form-label">Concurso <i
                                                            class="required">*</i></label>
                                                <select class="form-control form-control-lg" name="concurso"
                                                        id="concurso">
                                                    <option value="">Selecciona una opción</option>
                                                    <?php
                                                    $query = $db->query("SELECT * FROM concurso");
                                                    $fetch_concurso = $query->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($fetch_concurso as $concurso) { ?>
                                                        <option value="<?= $concurso->id_concurso ?>" <?= $datos["datos"]->id_concurso == $concurso->id_concurso ? 'selected' : '' ?>><?= $concurso->nombre_concurso ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <label for="clave" class="form-label">Elección Planilla <i
                                                            class="required">*</i></label>
                                                <select name="planillas[]" multiple="multiple"
                                                        class="form-select select_planilla">
                                                    <?php
                                                    $query = $db->query("SELECT * FROM planilla");
                                                    $fetch_planilla = $query->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($fetch_planilla as $planilla) { ?>
                                                        <option value="<?= $planilla->id_planilla ?>" <?php if (in_array($planilla->id_planilla, $datos["planillas"])) {
                                                            echo 'selected';
                                                        } ?>><?= $planilla->nombre_planilla ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="mb-3">
                                                    <label for="firma" class="form-label">Firma </label>
                                                    <small style="color:#BFC9CA;">Si no vas a modificar la firma, deja
                                                        este campo vacío.</small>
                                                    <input class="form-control" type="file" id="firma" name="firma">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-warning" onclick="editarJurado()">
                                            Registrar
                                        </button>
                                        <a href="jurados.php" class="btn btn-secondary">Volver</a>
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
        $(document).ready(function () {
            $('.select_planilla').select2({
                width: 'resolve'
            });
        });
        function editarJurado() {
            $.ajax({
                url: 'juradoController.php?action=actualizar',
                dataType: 'json',
                type: 'POST',
                data: $('#form-jurado').serialize(),
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
                        title: 'Jurado editado correctamente',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#FF751F'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = '<?= base_url ?>pages/administrador/jurados/jurados.php';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hubo un error al editar el jurado',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#FF751F'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = '<?= base_url ?>pages/administrador/jurados/jurados.php';
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>