<?php
require_once("../../config.php");

date_default_timezone_set('America/Bogota');

$query_concurso = $db->prepare("SELECT * FROM concurso WHERE fecha_evento = ? LIMIT 1");
$query_concurso->bindValue(1, date('Y-m-d', time()));
$query_concurso->execute();
$fetch_concurso = $query_concurso->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../head.php'; ?>
<title>Puntuación - BandRank</title>
<style>
    #tabla-puntuaciones {
        width: 82vw;
        overflow-x: scroll;
        height: 73vh;
    }
</style>
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
                    <h1>Tabla de puntuaciones</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Puntuaciones</a></div>
                        <div class="breadcrumb-item">Tiempo real</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Puntuación en tiempo real</h2>

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-12">
                                    <h4><b style="color: #FF914D;">Concurso:</b> <?= $fetch_concurso->nombre_concurso == null ? 'No hay concurso en marcha' : $fetch_concurso->nombre_concurso ?></h4>
                                </div
                            </div>

                            <div id="tabla-puntuaciones">

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
    $(document).ready(function () {
        recargarTablaPuntuaciones()
    })

    setInterval(recargarTablaPuntuaciones, 30000);

    function recargarTablaPuntuaciones() {
        $.ajax({
            url: 'tabla_puntuaciones.php',
            type: 'GET',
            dataType: 'html',

        }).done(function(html) {
            $('#tabla-puntuaciones').html(html);
        })
    }
</script>
</body>
</html>