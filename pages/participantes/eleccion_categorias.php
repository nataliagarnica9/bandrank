<?php
include_once('../../config.php');
if($_SESSION["ROL"] != 'jurado') {
    header("Location: inicio.php");
}
// Datos de ejemplo de categorías
$categorias = $db->prepare("SELECT c.*
                            FROM categorias_concurso c
                                     INNER JOIN categoriasxconcurso cc
                                                ON c.id_categoria = cc.id_categoria
                            WHERE cc.id_concurso = ?
                              AND eliminado = 0");
$categorias->bindValue(1,$_REQUEST["concurso"]);
$categorias->execute();
$fetch_categorias = $categorias->fetchAll(PDO::FETCH_OBJ);
$cantidad_categorias = count($fetch_categorias);
?>


<!DOCTYPE html>
<html lang="en">
<?php include '../../head.php'; ?>
<title>Categorias concursantes - BandRank</title>
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
                    <h1>Categorías</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Calificación</a></div>
                        <div class="breadcrumb-item">Categorías</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Elija la categoría a calificar</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row new-icons">
                                        <div class="col-sm-12">
                                            <div class="section-title mt-0">¡<?= $cantidad_categorias ?> categorías para elegir!</div>
                                            <div class="row">
                                                <?php foreach ($fetch_categorias as $i => $categoria) { ?>
                                                    <div class="col-sm-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <form action="eleccion_bandas.php" method="post"
                                                                      id="form-categorias<?= $i ?>">
                                                                    <input type="hidden" name="concurso" value="<?= $_REQUEST['concurso'] ?>">
                                                                    <input type="hidden" name="categoria" value="<?= $categoria->id_categoria ?>">
                                                                    <ul>
                                                                        <li onclick="enviar(<?= $i ?>)">
                                                                            <?php if ($i % 2 == 0) echo '<i class="fas fa-star-half" style="font-size: 20px"></i>'; else echo '<i class="far fa-star-half" style="font-size: 20px"></i>' ?>
                                                                            <?= $categoria->nombre_categoria ?></li>
                                                                    </ul>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                            </div>
                                        </div>
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

<script>
    function enviar(i) {
        $('#form-categorias'+i).submit();
    }
</script>
</body>
</html>