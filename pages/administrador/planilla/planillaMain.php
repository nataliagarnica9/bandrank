<?php
include_once('../../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>

<!doctype html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>
    <div class="container mt-navbar">
        <div id="contenedor-planillas">
            <div class="row">
                <h2 class="mb-5">
                    <strong>Planillas</strong>
                    <a href="creacionPlanilla.php" class="btn-bandrank" style="padding: 6px 9px; font-size: 14px;">
                        <i class="fas fa-plus"></i> Agregar nueva
                    </a>
                    <a id="btn-ver-eliminadas" href="javascript:void(0)" class="btn-bandrank" onclick="verPlanillasEliminadas()" style="padding: 6px 9px; font-size: 14px;">
                        <i class="fas fa-trash"></i> Ver eliminadas
                        <a id="btn-ver-existentes" class="btn-bandrank" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verPlanillasExistentes()">
                            <i class="fas fa-eye"></i> Ver existentes
                        </a>
                        <a href="../../../pages/administrador/inicio.php" class="btn btn-secondary" style="padding: 6px 9px; font-size: 14px;">Volver</a>
                    </a>
                </h2>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <table class="table table-bordered table-hover mt-5" id="tabla-planillas">
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
    <div class="modal" id="modalVerPlanilla" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Planilla</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <?php require("../../../footer.php"); ?>
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
                    url: 'planilla_controller.php?action=response',
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
            if (confirm('¿Estás seguro de que deseas eliminar esta planilla?')) {
                $.ajax({
                    url: 'planilla_controller.php?action=eliminarPlanilla',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id: id_planilla
                    }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-planillas').DataTable().ajax.reload();
                    } else {
                        console.log('error');
                    }
                });
            }
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
                    url: 'planilla_controller.php?action=verPlanillasEliminadas',
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
                    url: 'planilla_controller.php?action=response',
                    type: "post",
                },
            });
            $('#btn-ver-existentes').hide();
            $('#btn-ver-eliminadas').show();
        }

        function restaurarPlanilla(id_planilla) {
            if (confirm('¿Estás seguro de que deseas restaurar esta planilla?')) {
                $.ajax({
                    url: 'planilla_controller.php?action=restaurarPlanilla',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id: id_planilla
                    }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-planillas').DataTable().ajax.reload();
                    } else {
                        console.log('error');
                    }
                });
            }
        }

        function eliminarPlanillaDefinitivamente(id_planilla) {
            if (confirm('¿Estás seguro de que deseas eliminar definitivamente esta planilla?')) {
                $.ajax({
                    url: 'planilla_controller.php?action=eliminarPlanillaDefinitivamente',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        id: id_planilla
                    }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-planillas').DataTable().ajax.reload();
                    } else {
                        console.log('error');
                    }
                });
            }
        }

        function editarPlanilla(id_planilla) {
            $.ajax({
                url: 'planilla_controller.php?action=actualizar_planilla',
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
    </script>
</body>

</html>