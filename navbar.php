<nav class="nav-br fixed-top mb-5">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            <a href="<?=base_url?>inicio.php"><img src="<?= base_url ?>dist/images/bandrank_isologo.png"
                    alt="Logo principal" class="img-logo"></a>
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
        <li>
            <a href="<?= base_url?>pages/administrador/jurados/jurados.php"><i class="fas fa-plus"></i> Registro</a>
            <ul class="rounded">
                <li><a href="<?= base_url ?>pages/administrador/jurados/jurados.php">Jurado</a></li>
                <li><a href="<?= base_url ?>pages/administrador/bandas/bandas.php">Banda</a></li>
                <li><a href="<?= base_url ?>pages/administrador/concurso/concursos.php">Concurso</a></li>
                <li><a href="<?= base_url ?>pages/administrador/criteriosEvaluacion/evaluacion.php">Criterio</a></li>
                <li><a href="<?= base_url ?>pages/administrador/planilla/planillaMain.php">Planilla</a></li>
            </ul>
        </li>
        </li>
        <li><a href="<?= base_url?>pages/puntuaciones.php">Ver en tiempo real</a></li>
        <li><a href="#">...</a></li>
    </ul>
</nav>