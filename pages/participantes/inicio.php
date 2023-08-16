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
            <a href="<?= base_url?>pages/participantes/jurados/jurados.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                    <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/jurado.png" width="40">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">Registro de jurado</h5>
                                <p class="card-text">Crea el perfil de jurado para poder realizar la calificación de las bandas participantes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/banda.png" width="50">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">Registro de banda participante</h5>
                                <p class="card-text">Crea el registro de la banda que participará en el concurso</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="#" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                    <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/penalizacion.png" width="40">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">Penalizacion</h5>
                                <p class="card-text">...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 m-5">
        <div class="col">
            <a href="<?= base_url?>pages/participantes/jurados/Categorias.php" class="tarjeta-opcion">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                    <div class="row">
                            <div class="col-2">
                                <img src="<?= base_url?>dist/images/jurado.png" width="40">
                            </div>
                            <div class="col-10">
                                <h5 class="card-title">concurso</h5>
                                <p class="card-text">Elige el concurso</p>
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