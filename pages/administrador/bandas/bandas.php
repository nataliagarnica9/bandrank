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

        <div id="contenedor-bandas">
            <div class="row">
                <h2 class="mb-5">
                    <strong>Bandas</strong>
                    <a href="creacionbandas.php" class="btn-bandrank" style="padding: 6px 9px; font-size: 14px;">
                        <i class="fas fa-plus"></i> Agregar nueva
                    </a>
                    <a id="btn-ver-existentes" class="btn-bandrank" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verBandasExistentes()">
                        <i class="fas fa-eye"></i> Ver existentes
                    </a>
                    <a href="../../../pages/administrador/inicio.php" class="btn btn-secondary"  style="padding: 6px 9px; font-size: 14px;">Volver</a>
                    
                </h2>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <table class="table table-bordered table-hover mt-5" id="tabla-banda">
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

    <div class="modal" id="modalVerPenalizacion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registro de banda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            </div>
        </div>
    </div>

    <?php require("../../../footer.php"); ?>
    <script>
    $(document).ready(function() {
        $('#tabla-banda').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'bandas_controller.php?action=response', // Ajusta la ruta al controlador de penalizaciones
                type: "post",
            },
        });
    });

    

    function eliminarBanda(id_banda) {
        if (confirm('¿Estás seguro de que deseas eliminar esta banda?')) {
            $.ajax({
                url: 'bandas_controller.php?action=eliminarBanda', // Ajusta la ruta al controlador de penalizaciones
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
        }
    }

    // Otras funciones para restaurar y eliminar definitivamente penalizaciones según necesites...

    function editarBandas(id_banda) {
        $.ajax({
            url: 'bandas_controller.php?action=editarBandas', // Ajusta la ruta al controlador de penalizaciones
            dataType: 'html',
            type: 'GET',
            data: {
                id: id_banda
            },
            success: function(response) {
                $('#contenedor-bandas').html(response); // Actualiza el contenido con el HTML de edición
            },
            error: function() {
                console.log('Error al cargar la banda para editar.');
            }
        });
    }
</script>

</body>
</html>