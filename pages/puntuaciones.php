<?php
require_once("../config.php");
$query_concurso = $db->prepare("SELECT * FROM concurso WHERE fecha_evento = ? LIMIT 1");
$query_concurso->bindValue(1, date('Y-m-d'));
$fetch_concurso = $query_concurso->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<?php require("../head.php"); ?>
<body>
    <div class="container">
    <a class="btn" href="<?=base_url?>inicio.php">Regresar</a>
        <div class="row">
            <div class="col-8">
                <h1>Puntuación en tiempo real</h1>
                <h4><b style="color: #FF914D;">Concurso:</b> <?= $fetch_concurso->nombre_concurso ?? 'No hay concurso en marcha' ?></h4>
            </div>
            <div class="col-4">
                <img src="<?=base_url?>dist/images/bandrank_logotipo.png" alt="Imagen oficial" style="width: 400px;">
            </div>
        </div>
    
        <table class="table table-hover table-sm table-bordered mt-5">
            <thead>
                <tr>
                    <td rowspan="2">Banda</td>
                    <td colspan="5" class="text-center">Planilla # 1</td>
                    <td colspan="5" class="text-center">Planilla # 2</td>
                    <td colspan="5" class="text-center">Planilla # 3</td>
                    <td rowspan="2" class="text-center">Totales</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Grupo frontera</td>
                    <td>1.5</td>
                    <td>2.5</td>
                    <td>3.5</td>
                    <td>4.5</td>
                    <td>5.5</td>
                    <td>1.5</td>
                    <td>2.5</td>
                    <td>3.5</td>
                    <td>4.5</td>
                    <td>5.5</td>
                    <td>1.5</td>
                    <td>2.5</td>
                    <td>3.5</td>
                    <td>4.5</td>
                    <td>5.5</td>
                    <td>55</td>
                </tr>
            </thead>
        </table>
    </div>
</body>
<?php require("../footer.php"); ?>
<script>
</script>
</html>