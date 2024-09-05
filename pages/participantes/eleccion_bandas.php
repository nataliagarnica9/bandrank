<?php
include_once('../../config.php');
if($_SESSION["ROL"] != 'jurado') {
    header("Location: ".base_url."inicio.php");
}

$banda = $db->prepare("select * from banda where id_concurso = ? and id_categoria = ?");
$banda->bindValue(1,$_POST["concurso"]);
$banda->bindValue(2,$_POST["categoria"]);
$banda->execute();
$fetch_banda = $banda->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../head.php'; ?>
<title>Bandas concursantes - BandRank</title>
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
                    <h1>Bandas</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Calificación</a></div>
                        <div class="breadcrumb-item">Bandas</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Elija la banda a calificar</h4>
                                    <a href="<?= base_url ?>pages/participantes/eleccion_categorias.php?concurso=<?= $_SESSION["ID_CONCURSO"] ?>" class="btn btn-secondary"> Volver</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-md">
                                            <tr>
                                                <th>Nombre de la banda</th>
                                                <th>Acciones</th>
                                            </tr>
                                            <?php foreach ($fetch_banda as $banda) {?>
                                                <tr>
                                                    <form action="eleccion_planilla.php" method="post">
                                                        <input type="hidden" name="concurso" value="<?= $_POST["concurso"] ?>">
                                                        <input type="hidden" name="categoria" value="<?= $_POST["categoria"] ?>">
                                                        <input type="hidden" name="banda" value="<?= $banda->id_banda ?>">
                                                            <td><?=$banda->nombre?></td>
                                                            <td><button type="submit" class="btn btn-primary">Seleccionar</button></td>
                                                    </form>
                                                </tr>

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
