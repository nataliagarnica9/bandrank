<?php
include_once('../../../config.php');
if($_SESSION["ROL"] == 'instructor' || $_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == '') {
    header("Location: ".base_url."inicio.php");
}
?>

<!doctype html>
<html lang="es">
    <?php require("../../../head.php"); ?>
<body>
<?php require("../../../navbar.php");?>

<div class="container">
    <?php if(isset($_REQUEST["status"]) && $_REQUEST["status"] == 'success'): ?>
            <div class="alert-band">
                <i class="fas fa-check" style="color: #00FF00"></i> El registro se guardó exitosamente.
                <a href="registros.php" class="btn">Aceptar</a>
            </div>
    <?php elseif(isset($_REQUEST["message_error"])): ?>
            <div class="alert-band">
                <i class="fas fa-times" style="color:red;"></i> Ocurrió un error al realizar el registro <br>
                <?php echo $_REQUEST["message_error"]; ?>
                <a href="registros.php" class="btn">Aceptar</a>
            </div>
    <?php endif; ?>

    <h3><strong>Registro de categoría</strong></h3>

    <form action="registros_controller.php?action=guardar" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="nombre_categoria" class="form-label">Nombre categoría<i class="required">*</i></label>
                <input type="text" class="form-control form-control-lg" id="nombre_categoria" name="nombre_categoria" required autocomplete="off">
            </div>
        </div>
        <!--<div class="row">
            <div class="col-6 mb-3">
                <label for="correo" class="form-label">Concurso <i class="required">*</i></label>
                <select class="form-control form-control-lg" name="id_concurso" id="id_concurso">
                    <option value="">Selecciona una opción</option>
                    <?php 
                    //$query = $db->query("SELECT * FROM concurso");
                    //$fetch_concurso = $query->fetchAll(PDO::FETCH_OBJ);
                    //foreach($fetch_concurso as $concurso) { ?>
                    //    <option value=" //$concurso->id_concurso "> //$concurso->nombre_concurso</option>
                    <?php
                    //}
                    ?>
                </select>
            </div>
        </div>-->

        <button type="submit" class="btn-bandrank">Registrar</button>
    </form>

</div>

</body>
</html>