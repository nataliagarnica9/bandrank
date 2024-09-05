<?php
include_once('../../../config.php');
if ($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: " . base_url . "inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Criterios de Calificación - BandRank</title>
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
                    <h1>Criterios de calificación registrados</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Calificación</a></div>
                        <div class="breadcrumb-item">Registros</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Listado de criterios registrados</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="views/creacionCriterios.php" class="btn btn-warning"
                                       style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-plus"></i> Agregar nuevo
                                    </a>
                                    <a id="btn-ver-eliminados" href="javascript:void(0)" class="btn btn-danger"
                                       onclick="verCriteriosEliminados()" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-trash"></i> Ver eliminados
                                    </a>
                                    <a id="btn-ver-existentes" class="btn btn-secondary"
                                       style="display: none; padding: 6px 9px; font-size: 14px;"
                                       onclick="verCriteriosExistentes()">
                                        <i class="fas fa-eye"></i> Ver existentes
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="tabla-criterios">
                                            <thead>
                                            <tr>
                                                <th><b>Nombre del criterio</b></th>
                                                <th><b>Rango de calificación</b></th>
                                                <th><b>Planilla</b></th>
                                                <th><b>Acciones</b></th>
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
        <div class="modal fade" tabindex="-1" role="dialog" id="modalVerCriterio">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver criterio de calificación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"><b>Nombre del criterio:</b> </label>
                                <p id="nombre-criterio"></p>
                            </div>
                            <div class="col-4">
                                <label class="form-label"><b>Rango de calificación:</b> </label>
                                <p id="rango-calificacion"></p>
                            </div>
                            <div class="col-4">
                                <label class="form-label"><b>Planilla: </b></label>
                                <p id="nombre-planilla"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2023
                <div class="bullet"></div>
            </div>
            <div class="footer-right">
                <?php echo date('d') . ' de ' . date('M') . ' de ' . date('Y'); ?>
            </div>
        </footer>
    </div>
</div>

<!-- General JS Scripts -->
<?php include '../../../footer.php'; ?>

<script>
    $(document).ready(function () {
        $('#tabla-criterios').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'criteriosController.php?action=response',
                type: "post",
            },
        });
    });

    function eliminarCriterio(id_criterio) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas eliminar este criterio de evaluación?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'criteriosController.php?action=eliminarCriterio',
                    dataType: 'json',
                    type: 'POST',
                    data: {id: id_criterio}
                }).done(function (response) {
                    if (response.status == 'success') {
                        $('#tabla-criterios').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se pudo cargar la información',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#f3020a',
                        })
                    }
                });
            } else {
                Swal.close();
            }
        })
    }

    function verCriteriosEliminados() {
        $('#btn-ver-eliminados').hide();
        $('#btn-ver-existentes').show();
        $('#tabla-criterios').DataTable().destroy();
        $('#tabla-criterios').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'criteriosController.php?action=verCriteriosEliminados',
                type: "post",
            },
        });
    }

    function verCriteriosExistentes() {
        $('#btn-ver-eliminados').show();
        $('#btn-ver-existentes').hide();
        $('#tabla-criterios').DataTable().destroy();
        $('#tabla-criterios').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'criteriosController.php?action=response',
                type: "post",
            },
        });
    }

    function restaurarCriterio(id_criterio) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas restaurar este criterio?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'criteriosController.php?action=restaurarCriterio',
                    dataType: 'json',
                    type: 'POST',
                    data: {id: id_criterio}
                }).done(function (response) {
                    if (response.status == 'success') {
                        // Actualizar la tabla después de restaurar
                        $('#tabla-criterios').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se pudo cargar la información',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#f3020a',
                        })
                    }
                });
            }
        })
    }

    function eliminarCriterioDefinitivamente(id_criterio) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro de que deseas eliminar definitivamente este criterio?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'criteriosController.php?action=eliminarCriterioDefinitivamente',
                    dataType: 'json',
                    type: 'POST',
                    data: {id: id_criterio}
                }).done(function (response) {
                    if (response.status == 'success') {
                        // Actualizar la tabla después de eliminar definitivamente
                        $('#tabla-criterios').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se pudo cargar la información',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#f3020a',
                        })
                    }
                });
            }
        })
    }

    function editarCriterio(id_criterio) {
        location.href = 'criteriosController.php?action=actualizar_criterio&id='+id_criterio;
    }
</script>
</body>
</html>
