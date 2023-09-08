<?php
include_once('../../../config.php');

if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}

$query = $db->query("SELECT * FROM concurso WHERE finalizado = 1");
$fetch_concursos = $query->fetchAll(PDO::FETCH_OBJ);
$concursos_finalizados = count($fetch_concursos);

$query_bandas = $db->query("SELECT * FROM banda");
$fetch_bandas = $query_bandas->fetchAll(PDO::FETCH_OBJ);
$bandas = count($fetch_bandas);
?>
<!doctype html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>

    <div class="container mt-navbar">

        <div id="contenedor-concursos">
            <div class="row">
                <h2 class="mb-5"><strong>Concursos registrados</strong> <a onclick="crearNuevoConcurso()" class="btn-bandrank" style="padding: 6px 9px;font-size: 14px;"><i class="fas fa-plus"></i> Agregar nuevo</a>
                <a id="btn-ver-eliminados" href="javascript:void(0)" class="btn-bandrank" onclick="verConcursosEliminados()" style="padding: 6px 9px; font-size: 14px;">
             <i class="fas fa-trash"></i> Ver eliminados
                </a>
                <a id="btn-ver-existentes" class="btn-bandrank" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verConcursosExistentes()">
            <i class="fas fa-eye"></i> Ver existentes
            </a>
                <a href="../../../pages/administrador/inicio.php" class="btn btn-secondary"  style="padding: 6px 9px; font-size: 14px;">Volver</a></h2>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <h2><?= $concursos_finalizados ?></h2>
                                </div>
                                <div class="col-10">
                                    Concursos finalizados
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <h2><?= $bandas ?></h2>
                                </div>
                                <div class="col-10">
                                    Bandas inscritas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <table class="table table-bordered mt-5" id="tabla-concurso">
                        <thead>
                            <tr>
                                <td><b>Número de concurso</b></td>
                                <td><b>Nombre</b></td>
                                <td><b>Ubicación</b></td>
                                <td><b>Director</b></td>
                                <td><b>Acciones</b></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            
<div class="modal" id="modalVerConcurso" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Concurso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <b>Nombre del Concurso: </b> <span id="nombreConcurso"></span>
                    </div>
                    <div class="col-12 mb-2">
                        <b>Ubicación: </b><span id="ubicacionConcurso"></span>
                    </div>
                    <div class="col-12 mb-2">
                        <b>Director: </b><span id="directorConcurso"></span>
                    </div>
                    <div class="col-12 mb-2">
                        <b>Categoría: </b><span id="categoriaConcurso"></span>
                    </div>
                    <div class="col-12 mb-2">
                        <b>Fecha del Evento: </b><span id="fechaConcurso"></span>
                    </div>
                    <div class="col-12 mb-2">
                        <b>Estado: </b><span id="estadoConcurso"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
        

    </div>
    

    </div>
    <?php require("../../../footer.php"); ?>
    <script>
        $(document).ready(function() {
            $('#tabla-concurso').DataTable({
                language: {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 de 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "lengthMenu": " Mostrar:_MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                      "first": "Primero",
                      "last": "Ultimo",
                      "next": "Siguiente",
                      "previous": "Anterior"
                    }
                },
                "bProcessing": true,
                "serverSide": true,
                "order": [
                    [1, 'desc']
                ],
                "ajax": {
                    url: 'concurso_controller.php?action=response',
                    type: "post",
                },
            });
        });

        function crearNuevoConcurso() {
            $.ajax({
                url: 'concurso_controller.php?action=crear_concurso',
                dataType: 'html',
                type: 'GET',
            }).done(function(html) {
                $('#contenedor-concursos').html(html);
            });
        }

        function registrarConcurso() {
            $.ajax({
                url: 'concurso_controller.php?action=save',
                dataType: 'json',
                type: 'POST',
                data: $('#form_concurso').serialize()
            }).done(function(response) {
                if (response.status == 'success') {
                    location.reload();
                } else {
                    console.log('error');
                }
            });
        }

        /////////////////////////////////////////

        function editarConcurso(id_concurso) {
    $.ajax({
        url: 'concurso_controller.php?action=actualizar_concurso', // Ajusta la ruta al controlador de concursos
        dataType: 'html',
        type: 'GET',
        data: {
            id: id_concurso
        },
        success: function(response) {
            console.log(response);
            $('#contenedor-concursos').html(response); // Actualiza el contenido con el HTML de edición de concursos
        },
        error: function() {
            console.log('Error al cargar el concurso para editar.');
        }
    });
}
function verDatosConcurso(id_concurso) {
    $.ajax({
        url: 'concurso_controller.php?action=datos_concurso&id=' + id_concurso, // Ajusta la ruta al controlador de concursos
        dataType: 'json',
        type: 'GET',
        data: {
            id_concurso: id_concurso
        }
    }).done(function(response) {
        if (response.status == 'success') {
            $('#modalVerConcurso').modal('show'); // Muestra el modal
            $('#nombreConcurso').html(response.data.datos.nombre_concurso);
            $('#ubicacionConcurso').html(response.data.datos.ubicacion);
            $('#directorConcurso').html(response.data.datos.director);
            $('#categoriaConcurso').html(response.data.datos.nombre_categoria_concurso);
            $('#fechaConcurso').html(response.data.datos.fecha_evento);
            $('#estadoConcurso').html(response.data.datos.finalizado == '0' ? 'Activo' : 'Finalizado');
        } else {
            console.log('error');
        }
    });
}


//Eliminaciones

function eliminarConcurso(id_concurso) {
    if (confirm('¿Estás seguro de que deseas eliminar este concurso?')) {
        $.ajax({
            url: 'concurso_controller.php?action=eliminarConcurso',
            dataType: 'json',
            type: 'POST',
            data: { id: id_concurso }
        }).done(function(response) {
            if (response.status == 'success') {
                $('#tabla-concurso').DataTable().ajax.reload();
            } else {
                console.log('error');
            }
        });
    }
}

function verConcursosEliminados() {
    $('#btn-ver-eliminados').hide();
    $('#btn-ver-existentes').show();
    $('#tabla-concurso').DataTable().destroy();
    $('#tabla-concurso').DataTable({
        "bProcessing": true,
        "serverSide": true,
        "order": [
            [0, 'asc']
        ],
        "ajax": {
            url: 'concurso_controller.php?action=verConcursosEliminados',
            type: "post",
        },
    });
}

function verConcursosExistentes() {
    $('#btn-ver-eliminados').show();
    $('#btn-ver-existentes').hide();
    $('#tabla-concurso').DataTable().destroy();
    $('#tabla-concurso').DataTable({
        "bProcessing": true,
        "serverSide": true,
        "order": [
            [0, 'asc']
        ],
        "ajax": {
            url: 'concurso_controller.php?action=response',
            type: "post",
        },
    });
}

function restaurarConcurso(id_concurso) {
    if (confirm('¿Estás seguro de que deseas restaurar este concurso?')) {
        $.ajax({
            url: 'concurso_controller.php?action=restaurarConcurso',
            dataType: 'json',
            type: 'POST',
            data: { id: id_concurso }
        }).done(function(response) {
            if (response.status == 'success') {
                // Actualizar la tabla después de restaurar
                $('#tabla-concurso').DataTable().ajax.reload();
            } else {
                console.log('error');
            }
        });
    }
}

function eliminarConcursoDefinitivamente(id_concurso) {
    if (confirm('¿Estás seguro de que deseas eliminar definitivamente este concurso?')) {
        $.ajax({
            url: 'concurso_controller.php?action=eliminarConcursoDefinitivamente',
            dataType: 'json',
            type: 'POST',
            data: { id: id_concurso }
        }).done(function(response) {
            if (response.status == 'success') {
                // Actualizar la tabla después de eliminar definitivamente
                $('#tabla-concurso').DataTable().ajax.reload();
            } else {
                console.log('error');
            }
        });
    }
}

    </script>
</body>

</html>