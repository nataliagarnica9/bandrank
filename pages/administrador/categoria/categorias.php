<?php
include_once('../../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../../head.php'; ?>
<title>Categorías - BandRank</title>
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
                    <h1>Categorías registradas</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Categorías</a></div>
                        <div class="breadcrumb-item">Registros</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Listado de categorías registradas</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="views/creacionCategoria.php" class="btn btn-warning" style="padding: 6px 9px; font-size: 14px;">
                                        <i class="fas fa-plus"></i> Agregar categoría
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md" id="tabla-categoria">
                                            <thead>
                                            <tr>
                                                <td><b>Nombre de la categoría</b></td>
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
    </div>
</div>
<!-- General JS Scripts -->
<?php include '../../../footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#tabla-categoria').DataTable({
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
                url: 'categoriasController.php?action=response',
                type: "post",
            },
        });
    });

    function eliminar(id) {
        Swal.fire({
            icon: 'info',
            title: '¿Estás seguro de que deseas eliminar esta categoría?',
            allowEscapeKey: false,
            allowOutsideClick: false,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#FF751F',
            showDenyButton: true,
            denyButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'categoriasController.php?action=eliminar', // Ajusta la ruta al controlador de penalizaciones
                    dataType: 'json',
                    type: 'POST',
                    data: { id: id }
                }).done(function(response) {
                    if (response.status == 'success') {
                        $('#tabla-categoria').DataTable().ajax.reload();
                    } else {
                        console.log('error');
                    }
                });
            } else {
                Swal.close()
            }
        });
    }
</script>
</body>
</html>