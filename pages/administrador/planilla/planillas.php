<?php
include_once('../../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Planillas - BandRank</title>
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
                    <h1>Planillas registradas</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Planillas</a></div>
                        <div class="breadcrumb-item">Registros</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Listado de planillas registradas</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="views/creacionPlanilla.php" class="btn btn-warning mr-2" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-plus"></i> Agregar nueva
                                    </a>
                                    <a id="btn-ver-eliminadas" href="javascript:void(0)" class="btn btn-danger" onclick="verPlanillasEliminadas()" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-trash"></i> Ver eliminadas
                                    </a>

                                    <a id="btn-ver-existentes" class="btn btn-secondary" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verPlanillasExistentes()">
                                        <i class="fas fa-eye"></i> Ver existentes
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="tabla-planillas">
                                            <thead>
                                                <tr>
                                                    <td><b>Nombre de la planilla</b></td>
                                                    <td><b>Concurso</b></td>
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
        <div class="modal fade" tabindex="-1" role="dialog" id="modalVerPlanilla">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver planilla</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label"><b>Nombre de la planilla:</b> </label>
                                <p id="nombre-planilla"></p>
                            </div>
                            <div class="col-6">
                                <label class="form-label"><b>Concurso:</b> </label>
                                <p id="nombre-concurso"></p>
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
        $.fn.dataTableExt.sErrMode = 'none';

        $('#tabla-planillas').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'planillaController.php?action=response',
                type: "post",
            },
            paging: 'true',
            "language": {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Del _START_ al _END_ de un total de _TOTAL_ reg.",
                sInfoEmpty: "0 registros",
                sInfoFiltered: "(filtrado de _MAX_ reg.)",
                sInfoPostFix: "",
                sSearch: "Buscar:",
                sUrl: "",
                sInfoThousands: ",",
                sLoadingRecords: "Cargando...",
                //sDom: "tlip",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Sig",
                    sPrevious: "Ant"
                },
                oAria: {
                    sSortAscending:
                        ": Activar para ordenar la columna de manera ascendente",
                    sSortDescending:
                        ": Activar para ordenar la columna de manera descendente"
                }
            },
        });
    });

    //Eliminar planilla
    function eliminarPlanilla(id_planilla) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas eliminar esta planilla?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'planillaController.php?action=eliminarPlanilla',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id: id_planilla
                    }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-planillas').DataTable().ajax.reload();
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

    function verPlanillasEliminadas() {
        $('#tabla-planillas').DataTable().destroy();
        $('#tabla-planillas').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'planillaController.php?action=verPlanillasEliminadas',
                type: "post",
            },
        });
        $('#btn-ver-eliminadas').hide();
        $('#btn-ver-existentes').show();
    }

    function verPlanillasExistentes() {
        $('#tabla-planillas').DataTable().destroy();
        $('#tabla-planillas').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'planillaController.php?action=response',
                type: "post",
            },
        });
        $('#btn-ver-existentes').hide();
        $('#btn-ver-eliminadas').show();
    }

    function restaurarPlanilla(id_planilla) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro de que deseas restaurar esta planilla?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'planillaController.php?action=restaurarPlanilla',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id: id_planilla
                    }
                }).done(function (response) {
                    if (response.status == 'success') {
                        $('#tabla-planillas').DataTable().ajax.reload();
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

    function eliminarPlanillaDefinitivamente(id_planilla) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro de que deseas eliminar definitivamente esta planilla?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'planillaController.php?action=eliminarPlanillaDefinitivamente',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id: id_planilla
                    }
                }).done(function (response) {
                    if (response.status == 'success') {
                        $('#tabla-planillas').DataTable().ajax.reload();
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

    function editarPlanilla(id_planilla) {
        $.ajax({
            url: 'planillaController.php?action=actualizar_planilla',
            dataType: 'html',
            type: 'GET',
            data: {
                id: id_planilla
            },
            success: function(response) {
                console.log(response);
                $('#contenedor-planillas').html(response); // Actualiza el contenido con el HTML de edición
            },
            error: function() {
                console.log('Error al cargar la planilla para editar.');
            }
        });
    }

    function editarPlanilla(id_planilla) {
        location.href = 'planillaController.php?action=actualizar_planilla&id='+id_planilla;
    }
</script>
</body>
</html>