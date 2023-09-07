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

        <div id="contenedor-jurado">
        <?php if (isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success') : ?>
            <div class="alert-band">
                <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó y/o actualizó exitosamente.
                <a href="jurados.php" class="btn">Aceptar</a>
            </div>
        <?php elseif (isset($_REQUEST["message_error"])) : ?>
            <div class="alert-band">
                <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
                <?php echo $_REQUEST["message_error"]; ?>
                <a href="jurados.php" class="btn">Aceptar</a>
            </div>
        <?php endif; ?>

            <div class="row">
                <h2 class="mb-5"><strong>Jurados</strong> <a onclick="crearNuevoJurado()" class="btn-bandrank" style="padding: 6px 9px;font-size: 14px;"><i class="fas fa-plus"></i> Agregar nuevo</a>
                <a href="../../../pages/administrador/inicio.php" class="btn btn-secondary"  style="padding: 6px 9px; font-size: 14px;">Volver</a></h2>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-striped mt-5" id="tabla-jurado">
                        <thead>
                            <tr>
                                <td><b>Nombres</b></td>
                                <td><b>Documento</b></td>
                                <td><b>Correo</b></td>
                                <td><b>Concurso</b></td>
                                <td><b>Acciones</b></td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="modal" id="modalVerJurado" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jurado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <b>Nombres: </b> <span id="nombres"></span>
                        </div>
                        <div class="col-12 mb-2">
                            <b>Documento: </b><span id="documento"></span>
                        </div>
                        <div class="col-12 mb-2">
                            <b>Concurso: </b><span id="concurso"></span>
                        </div>
                        <div class="col-12 mb-2">
                            <b>Celular: </b><span id="celular"></span>
                        </div>
                        <div class="col-12 mb-2">
                            <b>Correo: </b><span id="correo"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label class="form-label"><b>Firma: </b></label>
                            <br>
                            <img id="firma" style="width: 150px;">
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
            $('#tabla-jurado').DataTable({
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
                    [0, 'asc']
                ],
                "ajax": {
                    url: 'jurado_controller.php?action=response',
                    type: "post",
                },
            });
        });

        function crearNuevoJurado() {
            $.ajax({
                url: 'jurado_controller.php?action=crear_jurado',
                dataType: 'html',
                type: 'GET',
            }).done(function(html) {
                $('#contenedor-jurado').html(html);
            });
        }

        function registrarJurado() {
            $.ajax({
                url: 'jurado_controller.php?action=guardar',
                dataType: 'json',
                type: 'POST',
                data: $('#form_jurado').serialize()
            }).done(function(response) {
                if (response.status == 'success') {
                    location.reload();
                } else {
                    console.log('error');
                }
            });
        }

        function verDatosJurado(id_jurado) {
            $.ajax({
                url: 'jurado_controller.php?action=datos_jurado&id=' + id_jurado,
                dataType: 'json',
                type: 'GET',
                data: {
                    id_jurado: id_jurado
                }
            }).done(function(response) {
                if (response.status == 'success') {
                    $('#modalVerJurado').modal('show');
                    $('#nombres').html(response.data.datos.nombres + " " + response.data.datos.apellidos);
                    $('#documento').html(response.data.datos.documento_identificacion);
                    $('#concurso').html(response.data.datos.nombre_concurso);
                    $('#celular').html(response.data.datos.celular);
                    $('#correo').html(response.data.datos.correo);
                    $('#firma').attr("src","../../../dist/images/firmas/" + response.data.datos.firma);
                } else {
                    console.log('error');
                }
            });
        }

        function editarDatosJurado(id_jurado) {
            $.ajax({
                url: 'jurado_controller.php?action=actualizar_jurado',
                dataType: 'html',
                type: 'GET',
                data: {
                    id: id_jurado
                }
            }).done(function(html) {
                $('#contenedor-jurado').html(html);
            });
        }

        function inactivarJurado(id_jurado) {
            $.ajax({
                url: 'jurado_controller.php?action=inactivar',
                dataType: 'json',
                type: 'POST',
                data: {
                    id: id_jurado
                }
            }).done(function(response) {
                if (response.status == 'success') {
                    console.log(response);
                    $('#tabla-jurado').DataTable().ajax.reload();
                } else {
                    console.log('error');
                }
            });
        }
    </script>
</body>

</html>