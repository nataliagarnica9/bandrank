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
<title>Resultados - BandRank</title>
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
                    <h1>Activities</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Activities</div>
                    </div>
                </div>
                <div class="section-body">
                    <h2 class="section-title">Categoría</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="activities">
                                <div class="activity">
                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                        <i class="fas fa-splotch"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">1er puesto</span>
                                            <span class="bullet"></span>
                                            <a class="text-job" href="#">..</a>
                                        </div>
                                        <p>Nombre instructor "<a href="#">Nombre de la banda</a>".</p>
                                    </div>
                                </div>

                                <div class="activity">
                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                        <i class="fas fa-splotch"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">2do puesto</span>
                                            <span class="bullet"></span>
                                            <a class="text-job" href="#">..</a>
                                        </div>
                                        <p>Nombre instructor "<a href="#">Nombre de la banda</a>".</p>
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