<!doctype html>
<html lang="es">
<?php require("../../head.php"); ?>

<body>
    <?php require("../../navbar.php"); ?>

    <div class="bloque-presentacion">
        <h1 class="titulo-bienv">Bienvenido a BandRank</h1>
        <p class="subtitulo-bienv mb-5">Sistema de Evaluación de Eventos Marciales</p>
        <p class="saludo-usuario">Hola! 
            <?php
                switch($_SESSION["ROL"]) {
                    case 'jurado':
                        $query = $db->prepare("SELECT CONCAT(nombres, ' ', apellidos) as nombre FROM jurado WHERE id_jurado = ?");
                        break;
                    case 'instructor':
                        $query = $db->prepare("SELECT nombre_instructor as nombre FROM banda WHERE id_banda = ?");
                        break;    
                }
                $query->bindValue(1,$_SESSION["ID_USUARIO"]);
                $query->execute();
                $fetch_usuario = $query->fetch(PDO::FETCH_OBJ);

                echo '<span style="color:#FF914D">'.$fetch_usuario->nombre. '</span><br> Ingresaste como ' . $_SESSION["ROL"];
            ?>
        </p>
        <div class="row row-cols-1 row-cols-md-3 g-4 m-5">
            <div class="col">
                <a href="<?= base_url ?>pages/participantes/jurados/Categorias.php?concurso=<?=$_SESSION["ID_CONCURSO"]?>" class="tarjeta-opcion">
                    <div class="card border-light shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?= base_url ?>dist/images/copa.png" width="40">
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
            <div class="col">
                <a href="javascript:void(0)" onclick="parametrosExporte()" class="tarjeta-opcion">
                    <div class="card border-light shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="<?= base_url ?>dist/images/generar.png" width="40">
                                </div>
                                <div class="col-10">
                                    <h5 class="card-title">Generar</h5>
                                    <p class="card-text">Genera reporte de la planilla de calificación.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="bloque-vector">
            <img src="<?= base_url ?>dist/images/curva.png">
    </div>

    <div class="modal" id="modalExportePlanilla" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar planilla</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url?>pages/participantes/exportes/generarPlanilla.php" method="post">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <b>Banda: </b>
                                <br>
                                <select name="banda" id="banda" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                        // Obtengo las bandas del concurso
                                        $sel_bandas = $db->prepare("SELECT id_banda, nombre FROM banda WHERE id_concurso = ?");
                                        $sel_bandas->bindValue(1, $_SESSION["ID_CONCURSO"]);
                                        $sel_bandas->execute();

                                        $fetch_banda = $sel_bandas->fetchAll(PDO::FETCH_OBJ);

                                        foreach($fetch_banda as $banda) { ?>
                                            <option value="<?=$banda->id_banda?>"><?=$banda->nombre?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 mb-2">
                                <b>Planilla: </b>
                                <br>
                                <select name="planilla" id="planilla" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                        // Obtengo las bandas del concurso
                                        $sel_planillas = $db->prepare("SELECT id_planilla, nombre_planilla FROM planilla WHERE id_concurso = ?");
                                        $sel_planillas->bindValue(1, $_SESSION["ID_CONCURSO"]);
                                        $sel_planillas->execute();

                                        $fetch_planillas = $sel_planillas->fetchAll(PDO::FETCH_OBJ);

                                        foreach($fetch_planillas as $planilla) { ?>
                                            <option value="<?=$planilla->id_planilla?>"><?=$planilla->nombre_planilla?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-bandrank">Generar</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <?php require("../../footer.php"); ?>
    <script>
        function parametrosExporte() {
            $('#modalExportePlanilla').modal('show');
        }
    </script>
</body>

</html>