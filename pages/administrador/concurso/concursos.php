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
<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Concursos - BandRank</title>
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
                    <h1>Concursos registrados</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Concursos</a></div>
                        <div class="breadcrumb-item">Registros</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Listado de concursos registrados</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?=base_url?>pages/administrador/concurso/views/creacionConcurso.php" class="btn btn-icon icon-left btn-warning"><i class="fas fa-plus"></i> Nuevo concurso</a> &nbsp;&nbsp;
                                    <a id="btn-ver-eliminados" href="javascript:void(0)" class="btn btn-icon icon-left btn-danger" onclick="verConcursosEliminados()">
                                        <i class="fas fa-trash"></i> Ver eliminados
                                    </a>
                                    <a id="btn-ver-existentes" class="btn-bandrank" style="display: none; padding: 6px 9px; font-size: 14px;" onclick="verConcursosExistentes()">
                                        <i class="fas fa-eye"></i> Ver existentes</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="tabla-concurso">
                                            <thead>
                                                <tr>
                                                    <th>Número de concurso</th>
                                                    <th>Nombre</th>
                                                    <th>Ubicación</th>
                                                    <th>Director</th>
                                                    <th>Acciones</th>
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
                        <h5 class="modal-title">Ver concurso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                url: 'concursoController.php?action=response',
                type: "post",
            },
        });
    });

    function verDatosConcurso(id_concurso) {
        $.ajax({
            url: 'concursoController.php?action=datos_concurso&id=' + id_concurso, // Ajusta la ruta al controlador de concursos
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

    function registrarConcurso() {
        $.ajax({
            url: 'concursoController.php?action=save',
            dataType: 'json',
            type: 'POST',
            data: $('#form_concurso').serialize()
        }).done(function(response) {
            if (response.status == 'success') {
                location.reload();
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

    function editarConcurso(id_concurso) {
         location.href = 'concursoController.php?action=actualizar_concurso&id='+id_concurso;
    }

    function eliminarConcurso(id_concurso) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas eliminar este concurso?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'concursoController.php?action=eliminarConcurso', // Ajusta la ruta al controlador de penalizaciones
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_concurso }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-concurso').DataTable().ajax.reload();
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
                Swal.close()
            }
        });
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
                url: 'concursoController.php?action=verConcursosEliminados',
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
                url: 'concursoController.php?action=response',
                type: "post",
            },
        });
    }

    function restaurarConcurso(id_concurso) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas eliminar este concurso?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'concursoController.php?action=restaurarConcurso',
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_concurso }
                }).done(function(response) {
                    if (response.status == 'success') {
                        // Actualizar la tabla después de restaurar
                        $('#tabla-concurso').DataTable().ajax.reload();
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

    function eliminarConcursoDefinitivamente(id_concurso) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro/a de que deseas eliminar definitivamente este concurso?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'concursoController.php?action=eliminarConcursoDefinitivamente',
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id_concurso }
                }).done(function(response) {
                    if (response.status == 'success') {
                        // Actualizar la tabla después de eliminar definitivamente
                        $('#tabla-concurso').DataTable().ajax.reload();
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

</script>
</body>
</html>