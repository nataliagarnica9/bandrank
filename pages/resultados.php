<?php
require_once("../config.php");

date_default_timezone_set('America/Bogota');

//$query_concurso = $db->prepare("SELECT * FROM concurso WHERE fecha_evento = ? LIMIT 1");
//$query_concurso->bindValue(1, date('Y-m-d', time()));
//$query_concurso->execute();
//$fetch_concurso = $query_concurso->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<?php require("../head.php"); ?>
<style>
  <?php require("../dist/css/podio.css"); ?>
</style>

<body>
  <div class="container mt-5">
    <a class="btn" href="<?= base_url ?>pages/administrador/inicio.php">Regresar</a>
    <div class="row">
      <div class="col-8">
        <h1>Resultado de ganadores del concurso</h1>
        <h4><b style="color: #FF914D;">Concurso:</b> <?= $fetch_concurso->nombre_concurso == null ? 'No hay concurso en marcha' : $fetch_concurso->nombre_concurso ?></h4>
      </div>
      <div class="col-4">
        <img src="<?= base_url ?>dist/images/bandrank_logotipo.png" alt="Imagen oficial" style="width: 400px;">
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-2">
        <img src="<?= $base_url ?>../dist/images/uno.png" alt="Primer lugar" width="100px">
      </div>
      <div class="col-10">
        <p id="primer_puesto"></p>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-2">
        <img src="<?= $base_url ?>../dist/images/dos.png" alt="Segundo lugar" width="100px">
      </div>
      <div class="col-10">
      <p id="segundo_puesto"></p>
      </div>
    </div>

    <hr>
    <div class="row">
      <div class="col-2">
        <img src="<?= $base_url ?>../dist/images/tres.png" alt="Segundo lugar" width="100px">
      </div>
      <div class="col-10">
        <p id="tercer_puesto"></p>
      </div>
    </div>

    <?php require("../footer.php"); ?>
</body>

</html>