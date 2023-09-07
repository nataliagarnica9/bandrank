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

        <div id="contenedor-penalizaciones">
            <div class="row">
                <h2 class="mb-5">
                    <strong>Penalizaciones</strong>
                    <a href="creacionPenalizaciones.php" class="btn-bandrank" style="padding: 6px 9px; font-size: 14px;">
                        <i class="fas fa-plus"></i> Agregar nueva
                    </a>
                    <a id="btn-ver-eliminadas" href="javascript:void(0)" class="btn-bandrank" onclick="verPenalizacionesEliminadas()" style="padding: 6px 9px; font-size: 14px;">
                        <i class="fas fa-trash"></i> Ver eliminados
                    </a>
                    <a id="btn-ver-existentes" class="btn-bandrank" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verPenalizacionesExistentes()">
                        <i class="fas fa-eye"></i> Ver existentes
                    </a>
                    <a href="../../../pages/administrador/inicio.php" class="btn btn-secondary"  style="padding: 6px 9px; font-size: 14px;">Volver</a>
                    
                </h2>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <table class="table table-bordered table-hover mt-5" id="tabla-penalizaciones">
                        <thead>
                            <tr>
                                <td><b>Descripción</b></td>
                                <td><b>Tipo de penalización</b></td>
                                <td><b>Puntaje de penalización</b></td>
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
                    <h5 class="modal-title">Penalizacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <?php require("../../../footer.php"); ?>
    <script>
    $(document).ready(function() {
        $('#tabla-penalizaciones').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                url: 'penalizacion_controller.php?action=response', // Ajusta la ruta al controlador de penalizaciones
                type: "post",
            },
        });
    });

    

    function eliminarPenalizacion(id_penalizacion) {
        if (confirm('¿Estás seguro de que deseas eliminar esta penalización?')) {
            $.ajax({
                url: 'penalizacion_controller.php?action=eliminarPenalizacion', // Ajusta la ruta al controlador de penalizaciones
                dataType: 'json',
                type: 'POST',
                data: { id: id_penalizacion }
            }).done(function(response) {
                if (response.status == 'success') {
                    $('#tabla-penalizaciones').DataTable().ajax.reload();
                } else {
                    console.log('error');
                }
            });
        }
    }

    function restaurarPenalizacion(id_penalizacion) {
    if (confirm('¿Estás seguro de que deseas restaurar esta penalización?')) {
        $.ajax({
            url: 'penalizacion_controller.php?action=restaurarPenalizacion',
            dataType: 'json',
            type: 'POST',
            data: { id: id_penalizacion }
        }).done(function(response) {
            if (response.status == 'success') {
                // Actualizar la tabla después de restaurar
                $('#tabla-penalizaciones').DataTable().ajax.reload();
            } else {
                console.log('error');
            }
        });
    }
}

function eliminarPenalizacionDefinitivamente(id_penalizacion) {
    if (confirm('¿Estás seguro de que deseas eliminar definitivamente esta penalización?')) {
        $.ajax({
            url: 'penalizacion_controller.php?action=eliminarPenalizacionDefinitivamente',
            dataType: 'json',
            type: 'POST',
            data: { id: id_penalizacion }
        }).done(function(response) {
            if (response.status == 'success') {
                // Actualizar la tabla después de eliminar definitivamente
                $('#tabla-penalizaciones').DataTable().ajax.reload();
            } else {
                console.log('error');
            }
        });
    }
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
                url: 'penalizacion_controller.php?action=verPenalizacionesEliminadas', // Ajusta la ruta al controlador de penalizaciones
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
                url: 'penalizacion_controller.php?action=response', // Ajusta la ruta al controlador de penalizaciones
                type: "post",
            },
        });
    }

    // Otras funciones para restaurar y eliminar definitivamente penalizaciones según necesites...

    function editarPenalizacion(id_penalizacion) {
        $.ajax({
            url: 'penalizacion_controller.php?action=actualizar_penalizacion', // Ajusta la ruta al controlador de penalizaciones
            dataType: 'html',
            type: 'GET',
            data: {
                id: id_penalizacion
            },
            success: function(response) {
                console.log(response);
                $('#contenedor-penalizaciones').html(response); // Actualiza el contenido con el HTML de edición
            },
            error: function() {
                console.log('Error al cargar la penalización para editar.');
            }
        });
    }
</script>

</body>
</html>
