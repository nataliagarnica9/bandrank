<!DOCTYPE html>
<html lang="en">
<?php require("head.php"); ?>
<body>
<?php require("navbar.php");?>

<div class="bloque-presentacion">
    <h1 class="titulo-bienv">Bienvenido a BandRank</h1>
    <p class="subtitulo-bienv">Sistema de Evaluación de Eventos Marciales</p>
    <button class="btn-bienv">Iniciar</button>
    <img src="<?= base_url?>dist/images/bandrank_isotipo.png" class="imagen-inicial" alt="Ilustración gráfica del sistema">
</div>
<div class="bloque-vector">
    <img src="<?= base_url?>dist/images/curva.png">
</div>
<div class="bloque-tarjetas">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <a href="<?= base_url?>pages/jurados/jurados.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Registro de jurado</h5>
                        <p class="card-text">Crea el perfil de jurado para poder realizar la calificación de las bandas participantes.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Registro de banda participante</h5>
                        <p class="card-text">...</p>
                    </div>
                </div>
            </a>
        </div>
        <!-- Evaluación -->
        <div class="col">
            <a href="<?= base_url?>pages/criteriosEvaluacion/evaluacion.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Criterios de Evaluación</h5>
                        <p class="card-text">Crea los distintos factores que se tendrán en cuenta a la hora de calificar las bandas.</p>
                    </div>
                    <!-- Evaluación -->
                </div>
        <div class="col">
            <a href="#" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Penalizacion</h5>
                        <p class="card-text">...</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>
</html>