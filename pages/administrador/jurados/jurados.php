<?php
include_once('../../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Jurados - BandRank</title>
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
                    <h1>Jurados registrados</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Jurados</a></div>
                        <div class="breadcrumb-item">Registros</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Listado de jurados registrados</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="views/creacionJurado.php" class="btn btn-warning" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-plus"></i> Agregar nuevo
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="tabla-jurado">
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
                    </div>
                </div>
            </section>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalVerJurado">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver jurado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
</div>
<!-- General JS Scripts -->
<?php include '../../../footer.php'; ?>

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
                url: 'juradoController.php?action=response',
                type: "post",
            },
        });
    });

    function registrarJurado() {
        $.ajax({
            url: 'juradoController.php?action=guardar',
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
            url: 'juradoController.php?action=datos_jurado&id=' + id_jurado,
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
        location.href = 'juradoController.php?action=actualizar_jurado&id='+id_jurado;
    }

    function inactivarJurado(id_jurado) {
        $.ajax({
            url: 'juradoController.php?action=inactivar',
            dataType: 'json',
            type: 'POST',
            data: {
                id: id_jurado
            }
        }).done(function(response) {
            if (response.status == 'success') {
                $('#tabla-jurado').DataTable().ajax.reload();
            } else {
                console.log('error');
            }
        });
    }
</script>
</body>
</html>