<!DOCTYPE html>
<html lang="en">
<?php require("head.php"); ?>
<body>
    <div class="bloque-inicial">
        <img src="<?=base_url?>dist/images/bandrank_isologo_blanco.png" class="img-inicio animate__animated animate__backInDown">
        <h1 class="animate__animated animate__backInDown">Bienvenido</h1>
        <p class="animate__animated animate__backInUp">
            ¿A dónde deseas ingresar?
        </p>
        <a href="<?= base_url ?>pages/administrador/inicio.php" class="btn-bandrank animate__animated animate__backInUp">Administrador</a>
        <a href="<?= base_url ?>pages/participantes/inicio.php" class="btn-bandrank animate__animated animate__backInUp">Participante</a>
    </div>
</body>
</html>