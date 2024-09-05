<?php
include_once('../../config.php');
if($_SESSION["ROL"] != 'jurado') {
    header("Location: ".base_url."inicio.php");
}

$planilla = $db->prepare("SELECT p.*
FROM planilla p
         INNER JOIN planillaxjurado pxj ON p.id_planilla = pxj.id_planilla
         INNER JOIN planillaxbanda pxb ON p.id_planilla = pxb.id_planilla
WHERE p.id_concurso = ?
  AND pxj.id_jurado = ?
  AND pxb.id_banda = ?");
$planilla->bindValue(1, $_POST["concurso"]);
$planilla->bindValue(2, $_SESSION["ID_USUARIO"]);
$planilla->bindValue(3, $_POST["banda"]);
$planilla->execute();
$fetch_planilla = $planilla->fetchAll(PDO::FETCH_OBJ);
?>


<!DOCTYPE html>
<html lang="en">
<?php include '../../head.php'; ?>
<title>Selección de planilla - BandRank</title>
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php include '../../navbar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Planilla</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Calificación</a></div>
                        <div class="breadcrumb-item">Planilla</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Elija la planilla para calificar</h4>
                                    <a href="<?= base_url ?>pages/participantes/eleccion_bandas.php?concurso=<?=$_POST['concurso']?>&categoria=<?=$_POST['banda']?>" class="btn btn-secondary"> Volver</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md">
                                            <tr>
                                                <th>Nombre de la banda</th>
                                                <th>Acciones</th>
                                            </tr>
                                            <?php
                                            foreach ($fetch_planilla as $planilla) {?>
                                                <form action="calificacion_jurados.php" method="post">
                                                    <input type="hidden" name="concurso" value="<?= $_POST["concurso"] ?>">
                                                    <input type="hidden" name="categoria" value="<?= $_POST["categoria"] ?>">
                                                    <input type="hidden" name="banda" value="<?= $_POST["banda"] ?>">
                                                    <input type="hidden" name="planilla" value="<?= $planilla->id_planilla ?>">
                                                    <!-- Este input es para validar libreria jquery con el campo de firmar -->
                                                    <input type="hidden" name="signature" value="on">
                                                    <tr>
                                                        <td><?=$planilla->nombre_planilla?></td>
                                                        <td><button type="submit" class="btn btn-primary">Seleccionar</button></td>
                                                    </tr>
                                                </form>
                                            <?php
                                            }
                                            ?>
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
<?php include '../../footer.php'; ?>
</body>
</html>

<div class="dataTables_paginate paging_simple_numbers" id="tabla-banda_paginate">
    <a class="paginate_button previous disabled" aria-controls="tabla-banda" data-dt-idx="0" tabindex="-1"
            id="tabla-banda_previous">Previous</a>
    <span>
        <a class="paginate_button current" aria-controls="tabla-banda"
                                                           data-dt-idx="1" tabindex="0">1
        </a>
    </span>
    <a class="paginate_button next disabled" aria-controls="tabla-banda" data-dt-idx="2" tabindex="-1"
            id="tabla-banda_next">Next</a>
</div>

