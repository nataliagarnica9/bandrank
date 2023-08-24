<?php
include_once('../../../config.php');

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
    </script>
</body>

</html>