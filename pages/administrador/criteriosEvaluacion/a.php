<!doctype html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>

    <div class="container mt-navbar">

        <div id="contenedor-criterios">
            <div class="row">
                <h2 class="mb-5">
                    <strong>Criterios</strong>
                    <a href="creacionCriterios.php" class="btn-bandrank" style="padding: 6px 9px; font-size: 14px;">
                        <i class="fas fa-plus"></i> Agregar nuevo
                    </a>
                    <a id="btn-ver-eliminados" href="javascript:void(0)" class="btn-bandrank" onclick="verCriteriosEliminados()" style="padding: 6px 9px; font-size: 14px;">
                        <i class="fas fa-trash"></i> Ver eliminados
                    </a>
                    <a id="btn-ver-existentes" class="btn-bandrank" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verCriteriosExistentes()">
                        <i class="fas fa-eye"></i> Ver existentes
                    </a>
                </h2>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <table class="table table-bordered table-hover mt-5" id="tabla-criterios">
                        <thead>
                            <tr>
                                <td><b>Nombre del criterio</b></td>
                                <td><b>Rango de calificación</b></td>
                                <td><b>Planilla</b></td>
                                <td><b>Acciones</b></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal" id="modalVerCriterio" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Criterio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <?php require("../../../footer.php"); ?>
     <script>
        $(document).ready(function() {
            $('#tabla-criterios').DataTable({
                "bProcessing": true,
                "serverSide": true,
                "order": [
                    [0, 'asc']
                ],
                "ajax": {
                    url: 'criterio_controller.php?action=response',
                    type: "post",
                },
            });
        });
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
                    url: 'criterio_controller.php?action=verCriteriosEliminados',
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
                    url: 'criterio_controller.php?action=response',
                    type: "post",
                },
            });
        }

        // ... Rest of the script ...

    </script>

</body>
</html>
