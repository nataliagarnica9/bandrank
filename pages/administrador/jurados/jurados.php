<!doctype html>
<html lang="es">
<?php require("../../../head.php"); ?>

<body>
    <?php require("../../../navbar.php"); ?>

    <div class="container mt-navbar">

        <div id="contenedor-jurado">
            <div class="row">
                <h2 class="mb-5"><strong>Jurados</strong> <a onclick="crearNuevoJurado()" class="btn-bandrank" style="padding: 6px 9px;font-size: 14px;"><i class="fas fa-plus"></i> Agregar nuevo</a></h2>

            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <table class="table table-bordered table-hover mt-5" id="tabla-concurso">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jurado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label"><b>Nombres:</b> </label>
                            <p id="nombres"></p>
                        </div>
                        <div class="col-4">
                            <label class="form-label"><b>Documento:</b> </label>
                            <p id="documento"></p>
                        </div>
                        <div class="col-4">
                            <label class="form-label"><b>Concurso: </b></label>
                            <p id="concurso"></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <label class="form-label"><b>Celular: </b></label>
                            <p id="celular"></p>
                        </div>
                        <div class="col-4">
                            <label class="form-label"><b>Correo: </b></label>
                            <p id="correo"></p>
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
            $('#tabla-concurso').DataTable({
                "bProcessing": true,
                "serverSide": true,
                "order": [
                    [1, 'desc']
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
                    $('#nombres').html(response.data[0].nombres + " " + response.data[0].apellidos);
                    $('#documento').html(response.data[0].documento_identificacion);
                    $('#concurso').html(response.data[0].id_concurso);
                    $('#celular').html(response.data[0].celular);
                    $('#correo').html(response.data[0].correo);
                    $('#firma').attr("src","../../../dist/images/firmas/" + response.data[0].firma);
                } else {
                    console.log('error');
                }
            });
        }
    </script>
</body>

</html>