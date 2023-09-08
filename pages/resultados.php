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
<body>
    <div class="container">
    <a class="btn" href="<?=base_url?>pages/administrador/inicio.php">Regresar</a>
        <div class="row">
            <div class="col-8">
                <h1>Resultado de ganadores del concurso</h1>
                <h4><b style="color: #FF914D;">Concurso:</b> <?= $fetch_concurso->nombre_concurso == null ? 'No hay concurso en marcha' : $fetch_concurso->nombre_concurso ?></h4>
            </div>
            <div class="col-4">
                <img src="<?=base_url?>dist/images/bandrank_logotipo.png" alt="Imagen oficial" style="width: 400px;">
            </div>
        </div>
    
        <div id="tabla-resultados">

        </div>
    </div>
</body>
</html>