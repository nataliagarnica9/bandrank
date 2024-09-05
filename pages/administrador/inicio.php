<?php
include_once('../../config.php');
if($_SESSION["ROL"] != 'admin') {
    header("Location: ../../inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../head.php'; ?>
<title>Inicio - BandRank</title>
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
                    <h1>Bienvenido/a a BandRank</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Inicio</a></div>
                        <div class="breadcrumb-item">Página de bienvenida</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Resumen</h2>
                    <p class="section-lead">
                        Sistema de gestión y evaluación de eventos marciales.
                    </p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-drum"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Concurso</h4>
                                    <p>Crea, edita y administra los concursos en marcha.</p>
                                    <a href="<?= base_url ?>pages/administrador/concurso/concursos.php" class="card-cta">Ingresar <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Bandas</h4>
                                    <p>Crea, edita y administra las bandas participantes.</p>
                                    <a href="<?= base_url ?>pages/administrador/bandas/bandas.php" class="card-cta">Administrar <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="far fa-list-alt"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Planillas</h4>
                                    <p>Crea, edita y administra las planillas de calificación.</p>
                                    <a href="<?= base_url ?>pages/administrador/planilla/planillaMain.php" class="card-cta">Ir a crear <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Categorías</h4>
                                    <p>Crea, edita y administra las categorías.</p>
                                    <a href="<?= base_url ?>pages/administrador/categoria/categorias.php" class="card-cta">Administrar <i class="fas fa-chevron-right"></i></a>
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