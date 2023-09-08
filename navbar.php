<?php
include_once('config.php');
if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] == 'admin') {
    $url_inicio = base_url . "pages/administrador/inicio.php";
    $boton_home = '<a href="' . base_url . 'autenticacion.php?type=logout" style="color:#000;">Volver a inicio</a>';
} elseif (isset($_SESSION["ROL"]) && ($_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == 'instructor')) {
    $url_inicio = base_url . "pages/participantes/inicio.php";
    $boton_home = '<a href="' . base_url . 'autenticacion.php?type=logout" style="color:#000;">Cerrar sesión</a>';
} else {
    $url_inicio = base_url . "inicio.php";
    $boton_home = '';
}
?>
<nav class="nav-br fixed-top mb-5 shadow-sm">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            <a href="<?= $url_inicio ?>"><img src="<?= base_url ?>dist/images/bandrank_isologo.png" alt="Logo principal" class="img-logo"></a>
        </div>
    </div>
    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <ul class="nav-list">
        <?php if ($_SESSION["ROL"] == 'admin') : ?>
            <li>
                <a href="<?= base_url ?>pages/administrador/jurados/jurados.php">Registro <i class="fas fa-caret-down"></i></a>
                <ul class="rounded">
                    <li><a href="<?= base_url ?>pages/administrador/jurados/jurados.php">Jurado</a></li>
                    <li><a href="<?= base_url ?>pages/administrador/bandas/bandas.php">Banda</a></li>
                    <li><a href="<?= base_url ?>pages/administrador/concurso/concursos.php">Concurso</a></li>
                    <li><a href="<?= base_url ?>pages/administrador/criteriosEvaluacion/criteriosMain.php">Criterio</a></li>
                    <li><a href="<?= base_url ?>pages/administrador/planilla/planillaMain.php">Planilla</a></li>
                    <li><a href="<?= base_url ?>pages/administrador/penalizacion/penalizacionMain.php">Penalización</a></li>
                    <li><a href="<?= base_url ?>pages/administrador/categoria/registros.php">Categoría</a></li>
                </ul>
            </li>
            <li><a href="<?= base_url ?>pages/puntuaciones.php">Ver en tiempo real</a></li>
        <?php endif; ?>
        <li><?= $boton_home ?></li>
    </ul>
</nav>