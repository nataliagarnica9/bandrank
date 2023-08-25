<!doctype html>
<html lang="es">
<?php require("../../head.php"); ?>

<body>
    <?php require("../../navbar.php");?>

    <div class="bloque-presentacion">
        <h1 class="titulo-bienv">Bienvenido a BandRank</h1>
        <p class="subtitulo-bienv mb-5">Sistema de Evaluación de Eventos Marciales</p>
        <div class="row row-cols-1 row-cols-md-3 g-4 m-5">
            <div class="col">
                <a href="<?= base_url?>pages/participantes/jurados/Categorias.php?concurso=1" class="tarjeta-opcion">
                    <div class="card border-light shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?= base_url?>dist/images/copa.png" width="40">
                                </div>
                                <div class="col-10">
                                    <h5 class="card-title">Concurso</h5>
                                    <p class="card-text">Elige el concurso al que deseas ingresar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
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