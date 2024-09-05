<?php
include_once('../../../../config.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../../head.php'; ?>
<title>Creación de categoría - BandRank</title>
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
                    <h1>Categorías</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Categorías</a></div>
                        <div class="breadcrumb-item">Crear</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Crear nueva categoría</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Ingresa la información de una nueva categoría</h6>
                                </div>
                                <div class="card-body">
                                    <form id="form_categoria" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="nombre_categoria" class="form-label">Nombre de la categoría <i class="required">*</i></label>
                                                <input type="text" class="form-control form-control-lg" id="nombre_categoria" name="nombre_categoria" required autocomplete="off">
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-warning" onclick="registrar()">Registrar</button>
                                        <a href="../categorias.php" type="button" class="btn btn-light">Volver</a>
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

    function registrar() {
        $.ajax({
            url: '../categoriasController.php?action=guardar',
            dataType: 'json',
            type: 'POST',
            data: $('#form_categoria').serialize(),
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
                    title: 'Categoría creada correctamente',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/categoria/categorias.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error al crear la categoria',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#FF751F'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?= base_url ?>pages/administrador/categoria/categorias.php';
                    }
                });
            }
        });
    }
</script>
</body>
</html>