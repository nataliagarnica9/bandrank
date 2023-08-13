<!doctype html>
<html lang="es">
<?php require("../../head.php"); ?>
<body>
<?php require("../../navbar.php");?>

<div class="bloque-presentacion">
    <h1 class="titulo-bienv">Bienvenido al administrador de BandRank</h1>
    <p class="subtitulo-bienv mb-5">Sistema de Evaluación de Eventos Marciales</p>
    <div class="row row-cols-1 row-cols-md-3 g-4 m-5">
        <div class="col-md-12 col-lg-4">
            <a href="<?= base_url ?>pages/administrador/concurso/concursos.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                    <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/jurado.png" width="40">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">Registro de competencias</h5>
                                <p class="card-text">Crea la competencia y permite la calificación del evento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-12 col-lg-4">
            <a href="<?= base_url ?>pages/administrador/criteriosEvaluacion/evaluacion.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/tambor.png" width="50">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">Registro de bandas</h5>
                                <p class="card-text">Crea las bandas participantes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-12 col-lg-4">
            <a href="<?= base_url ?>pages/administrador/criteriosEvaluacion/evaluacion.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/banda.png" width="50">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">Registro de calificaciones</h5>
                                <p class="card-text">Crea los estándares de calificación del concurso.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-12 col-lg-4">
            <a href="<?= base_url ?>pages/administrador/penalizacion/penalizacion.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                    <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/penalizacion.png" width="40">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">Penalizacion</h5>
                                <p class="card-text">Crea los items por los cuales se penaliza el puntaje.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--<img src="dist/images/bandrank_isotipo.png" class="imagen-inicial" alt="Ilustración gráfica del sistema">-->
</div>
<div class="bloque-vector">
    <img src="<?= base_url?>dist/images/curva.png">
</div>
<div class="bloque-tarjetas">
    
</div>

<?php require("../../footer.php");?>
</body>
</html>