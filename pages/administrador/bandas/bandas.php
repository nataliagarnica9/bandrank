<?php
include_once('../../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Bandas - BandRank</title>
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
                    <h1>Bandas registradas</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Bandas</a></div>
                        <div class="breadcrumb-item">Registros</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Listado de bandas registradas</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="views/creacionBandas.php" class="btn btn-warning" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-plus"></i> Agregar nueva
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="tabla-banda">
                                            <thead>
                                            <tr>
                                                <td><b>Nombre de la banda</b></td>
                                                <td><b>Ubicacion de la banda</b></td>
                                                <td><b>Nombre del instructor</b></td>
                                                <td><b>Acciones</b></td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalVerConcurso">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver banda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"><b>Nombre</b> </label>
                                <p id="descripcion-banda"></p>
                            </div>
                            <div class="col-4">
                                <label class="form-label"><b>Ubicación</b> </label>
                                <p id="tipo-banda"></p>
                            </div>
                            <div class="col-4">
                                <label class="form-label"><b>Nombre Instructor</b></label>
                                <p id="puntaje-banda"></p>
                            </div>
                        </div>
                    </div>
                    <!--<div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>-->
                </div>
            </div>
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
<!-- General JS Scripts -->
<?php include '../../../footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#tabla-banda').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'bandasController.php?action=response', // Ajusta la ruta al controlador de penalizaciones
                type: "post",
            },
        });
    });

    function eliminarBanda(id_banda) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro de que deseas eliminar esta banda?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'bandasController.php?action=eliminarBanda', // Ajusta la ruta al controlador de penalizaciones
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_banda }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-banda').DataTable().ajax.reload();
                    } else {
                        console.log('error');
                    }
                });
            } else {
                Swal.close()
            }
        });
    }

    function editarBandas(id_banda) {
        location.href = 'bandasController.php?action=editarBandas&id='+id_banda;
    }
</script>
</body>
</html>