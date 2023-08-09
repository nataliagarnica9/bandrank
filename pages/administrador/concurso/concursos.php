<!doctype html>
<html lang="es">
    <?php require("../../../head.php"); ?>
<body>
<?php require("../../../navbar.php");?>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2">
                <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
            </div>
        </div>
        <div class="row">
            <h2 class="mb-5"><strong>Concursos registrados</strong> <a onclic="crearNuevoConcurso()" class="btn-bandrank" style="padding: 6px 9px;font-size: 14px;"><i class="fas fa-plus"></i> Agregar nuevo</a></h2>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <h2>4</h2>
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
                        This is some text within a card body.
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        This is some text within a card body.
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
    <?php require("../../../footer.php");?>
    <script type="application/javascript">
    $(document).ready( function () {
        $('#tabla-concurso').DataTable({
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
    } );
</script>
</body>
</html>