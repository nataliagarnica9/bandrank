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
        });

        function eliminarPlanilla(id_planilla) {
            if (confirm('¿Estás seguro de que deseas eliminar esta planilla?')) {
                $.ajax({
                    url: 'planilla_controller.php?action=eliminarPlanilla',
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_planilla }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-planillas').DataTable().ajax.reload();
                    } else {
                        console.log('error');
                    }
                });
            }
        }

        // Resto de los scripts
    </script>
</body>
</html>
