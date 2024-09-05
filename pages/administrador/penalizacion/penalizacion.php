<?php
include_once('../../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Penalizaciones - BandRank</title>
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
                    <h1>Penalizaciones registradas</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Penalización</a></div>
                        <div class="breadcrumb-item">Registros</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Listado de penalizaciones registradas</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="views/creacionPenalizaciones.php" class="btn btn-warning mr-2" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-plus"></i> Agregar nueva
                                    </a>
                                    <a id="btn-ver-eliminadas" href="javascript:void(0)" class="btn btn-danger" onclick="verPenalizacionesEliminadas()" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-trash"></i> Ver eliminados
                                    </a>
                                    <a id="btn-ver-existentes" class="btn btn-secondary" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verPenalizacionesExistentes()">
                                        <i class="fas fa-eye"></i> Ver existentes
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="tabla-penalizaciones">
                                            <thead>
                                            <tr>
                                                <th><b>Descripción</b></th>
                                                <th><b>Tipo de penalización</b></th>
                                                <th><b>Puntaje de penalización</b></th>
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
        <div class="modal fade" tabindex="-1" role="dialog" id="modalVerPenalizacion">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver penalización</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"><b>Descripción de la penalización</b> </label>
                                <p id="descripcion-penalizacion"></p>
                            </div>
                            <div class="col-4">
                                <label class="form-label"><b>Tipo de penalización</b> </label>
                                <p id="tipo-penalizacion"></p>
                            </div>
                            <div class="col-4">
                                <label class="form-label"><b>Puntaje de penalización</b></label>
                                <p id="puntaje-penalizacion"></p>
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
    $(document).ready(function() {
        $('#tabla-penalizaciones').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'penalizacionController.php?action=response', // Ajusta la ruta al controlador de penalizaciones
                type: "post",
            },
        });
    });



    function eliminarPenalizacion(id_penalizacion) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas eliminar esta penalización?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'penalizacionController.php?action=eliminarPenalizacion',
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_penalizacion }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-penalizaciones').DataTable().ajax.reload();
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

    function restaurarPenalizacion(id_penalizacion) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas restaurar esta penalización?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'penalizacionController.php?action=restaurarPenalizacion',
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_penalizacion }
                }).done(function(response) {
                    if (response.status == 'success') {
                        // Actualizar la tabla después de restaurar
                        $('#tabla-penalizaciones').DataTable().ajax.reload();
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

    function eliminarPenalizacionDefinitivamente(id_penalizacion) {
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
                    url: 'penalizacionController.php?action=eliminarPenalizacionDefinitivamente',
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_penalizacion }
                }).done(function(response) {
                    if (response.status == 'success') {
                        // Actualizar la tabla después de eliminar definitivamente
                        $('#tabla-penalizaciones').DataTable().ajax.reload();
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
        });
    }


    function verPenalizacionesEliminadas() {
        // Ajusta los nombres de los botones y el comportamiento según tus necesidades
        $('#btn-ver-eliminadas').hide();
        $('#btn-ver-existentes').show();
        $('#tabla-penalizaciones').DataTable().destroy();
        $('#tabla-penalizaciones').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'penalizacionController.php?action=verPenalizacionesEliminadas', // Ajusta la ruta al controlador de penalizaciones
                type: "post",
            },
        });
    }

    function verPenalizacionesExistentes() {
        // Ajusta los nombres de los botones y el comportamiento según tus necesidades
        $('#btn-ver-eliminadas').show();
        $('#btn-ver-existentes').hide();
        $('#tabla-penalizaciones').DataTable().destroy();
        $('#tabla-penalizaciones').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'penalizacionController.php?action=response', // Ajusta la ruta al controlador de penalizaciones
                type: "post",
            },
        });
    }

    function editarPenalizacion(id_penalizacion) {
         location.href = 'penalizacionController.php?action=actualizar_penalizacion&id='+id_penalizacion;
    }
</script>
</body>
</html>
