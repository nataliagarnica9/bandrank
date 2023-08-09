<nav class="nav-br fixed-top mb-5">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            <a href="<?=base_url?>inicio.php"><img src="<?= base_url ?>dist/images/bandrank_isologo.png" alt="Logo principal" class="img-logo"></a>
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
            <a href="<?=base_url?>inicio.php"><i class="fas fa-home"></i></a>
        </li>
        <li>
            <a href="<?= base_url?>pages/participantes/jurados/jurados.php">Registro jurado</a></li>
        <li>
            <a href="#">Participación</a>
        </li>
        <li>
            <a href="#">Lectura de QR</a>
        </li>
    </ul>
</nav>