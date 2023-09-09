<!doctype html>
<html lang="es">
<?php require("../../head.php"); ?>

<body>
    <?php require("../../navbar.php"); ?>

    <div class="bloque-presentacion mt-navbar">
        <div class="row">
            <?php if ($_SESSION["ROL"] == 'instructor') : ?>
                <div class="col-12 col-md-4 p-3">
                <?php else : ?>
                    <div class="col-12 p-3">
                    <?php endif; ?>
                    <h3 class="titulo-bienv">Hola!</h3>
                    <!--<p class="subtitulo-bienv mb-5">Sistema de Evaluación de Eventos Marciales</p>-->
                    <p class="saludo-usuario">
                        <?php
                        switch ($_SESSION["ROL"]) {
                            case 'jurado':
                                $query = $db->prepare("SELECT CONCAT(j.nombres, ' ', j.apellidos) AS nombre, c.nombre_concurso AS nombre_concurso
                                               FROM jurado j
                                                        INNER JOIN concurso c ON j.id_concurso = c.id_concurso
                                               WHERE j.id_jurado = ?");
                                break;
                            case 'instructor':
                                $query = $db->prepare("SELECT b.nombre_instructor AS nombre, c.nombre_concurso, b.nombre as nombre_banda
                                               FROM banda b
                                                        INNER JOIN concurso c ON b.id_concurso = c.id_concurso
                                               WHERE b.id_banda = ?");
                                break;
                        }
                        $query->bindValue(1, $_SESSION["ID_USUARIO"]);
                        $query->execute();
                        $fetch_usuario = $query->fetch(PDO::FETCH_OBJ);

                        echo '<span style="color:#FF914D">' . $fetch_usuario->nombre . '</span><br> Ingresaste como ' . $_SESSION["ROL"] . ' al concurso ' . $fetch_usuario->nombre_concurso;
                        echo $fetch_usuario->nombre_banda != null ? '<br><br> Representas a la banda <span style="color:#FF914D">' . $fetch_usuario->nombre_banda . '</span>' : '';
                        ?>
                    </p>
                    <div class="row g-4">
                        <?php if ($_SESSION["ROL"] == 'jurado') : ?>
                            <div class="col-12">
                                <a href="<?= base_url ?>pages/participantes/Categorias.php?concurso=<?= $_SESSION["ID_CONCURSO"] ?>" class="tarjeta-opcion">
                                    <div class="card border-light shadow-sm">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">
                                                    <img src="<?= base_url ?>dist/images/copa.png" width="40">
                                                </div>
                                                <div class="col-10">
                                                    <h5 class="card-title">Iniciar</h5>
                                                    <p class="card-text">Elige la categoría a la que deseas ingresar.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="col-12">
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

                    <?php if ($_SESSION["ROL"] == 'instructor') : ?>
                        <div class="col-12 col-md-7">
                            <small>* Puedes hacer scroll para ver todos los puntajes</small>
                            <div id="tabla-puntuaciones" style="overflow-x: scroll;">

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
        </div>

        <?php if ($_SESSION["ROL"] == 'jurado') : ?>
            <div class="bloque-vector">
                <img src="<?= base_url ?>dist/images/curva.png">
            </div>
        <?php endif; ?>

        <div class="modal" id="modalExportePlanilla" tabindex="-1">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generar planilla</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url ?>pages/participantes/exportes/generarPlanilla.php" method="post" target="_blank">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <b>Banda: </b>
                                    <br>
                                    <select name="banda" id="banda" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        <?php
                                        // Obtengo las bandas del concurso
                                        if ($_SESSION["ROL"] == 'instructor') {
                                            $sel_bandas = $db->prepare("SELECT id_banda, nombre FROM banda WHERE id_concurso = ? AND id_banda = ?");
                                            $sel_bandas->bindValue(1, $_SESSION["ID_CONCURSO"]);
                                            $sel_bandas->bindValue(2, $_SESSION["ID_USUARIO"]);
                                        } else {
                                            $sel_bandas = $db->prepare("SELECT id_banda, nombre FROM banda WHERE id_concurso = ?");
                                            $sel_bandas->bindValue(1, $_SESSION["ID_CONCURSO"]);
                                        }
                                        $sel_bandas->execute();

                                        $fetch_banda = $sel_bandas->fetchAll(PDO::FETCH_OBJ);

                                        foreach ($fetch_banda as $banda) { ?>
                                            <option value="<?= $banda->id_banda ?>"><?= $banda->nombre ?></option>
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

                                        foreach ($fetch_planillas as $planilla) { ?>
                                            <option value="<?= $planilla->id_planilla ?>"><?= $planilla->nombre_planilla ?></option>
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

            <?php if ($_SESSION["ROL"] == 'instructor') : ?>
                $(document).ready(function() {
                    recargarTablaPuntuaciones()
                })
            
                setInterval(recargarTablaPuntuaciones, 30000);
            <?php endif; ?>

            function recargarTablaPuntuaciones() {
                $.ajax({
                    url: 'tabla_puntuaciones_unica.php',
                    type: 'GET',
                    dataType: 'html',

                }).done(function(html) {
                    $('#tabla-puntuaciones').html(html);
                })
            }

            function enviarCorreo() {
                $.ajax({
                    url: 'enviarCorreo.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        correo: 'natagarge@gmail.com'
                    },
                    beforeSend: function (){
                        Swal.fire({
                            icon: 'info',
                            title: 'Enviando correo',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    }
                }).done(function(response) {
                    if(response.status == '200' || response.status == 200){
                        Swal.fire({
                            icon: 'success',
                            title: 'Se envió el correo correctamente',
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No se pudo enviar el correo correctamente',
                            html: response.resp,
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        });
                    }
                })
            }
        </script>
</body>

</html>