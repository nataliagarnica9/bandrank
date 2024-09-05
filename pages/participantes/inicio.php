<?php
include_once('../../config.php');
if($_SESSION["ROL"] == '' || $_SESSION["ROL"] == 'admin') {
    header("Location: ../../inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include '../../head.php';

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

?>
<title>Inicio - BandRank</title>
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php include '../../navbar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <p class="saludo-usuario">
                    </p>
                    <h1>Bienvenido/a a BandRank</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Inicio</a></div>
                        <div class="breadcrumb-item">Página de bienvenida</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Resumen</h2>
                    <p class="section-lead">
                        <?php
                        echo '<span style="color:#FF914D">' . $fetch_usuario->nombre . '</span><br> Ingresaste como ' . $_SESSION["ROL"] . ' al concurso ' . $fetch_usuario->nombre_concurso;
                        echo $fetch_usuario->nombre_banda != null ? '<br><br> Representas a la banda <span style="color:#FF914D">' . $fetch_usuario->nombre_banda . '</span>' : '';
                    ?>
                    </p>

                    <div class="row">
                        <?php if ($_SESSION["ROL"] == 'jurado') : ?>
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="far fa-play-circle"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4>Empezar</h4>
                                        <p>Elige la categoría a la que deseas ingresar.</p>
                                        <a href="<?= base_url ?>pages/participantes/eleccion_categorias.php?concurso=<?= $_SESSION["ID_CONCURSO"] ?>" class="card-cta">Ingresar <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                                <div class="card-icon bg-primary text-white">
                                    <i class="far fa-file-pdf"></i>
                                </div>
                                <div class="card-body">
                                    <h4>Exportar</h4>
                                    <p>Genera reporte de la planilla de calificación.</p>
                                    <a href="javascript:void(0)" onclick="parametrosExporte()" class="card-cta">Exportar <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalExportePlanilla">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Generar planilla</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url ?>pages/participantes/exportes/generarPlanilla.php" method="post"
                          target="_blank">
                        <div class="modal-body">
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
                                        $sel_planillas = $db->prepare("SELECT p.id_planilla, p.nombre_planilla
                                                                              FROM planilla p
                                                                                       INNER JOIN planillaxbanda pb ON p.id_planilla = pb.id_planilla
                                                                              WHERE p.id_concurso = ?
                                                                                AND pb.id_banda = ?");
                                        $sel_planillas->bindValue(1, $_SESSION["ID_CONCURSO"]);
                                        $sel_planillas->bindValue(2, $_SESSION["ID_USUARIO"]);
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
                            <button type="submit" class="btn btn-warning">Generar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2023
                <div class="bullet"></div>
            </div>
            <div class="footer-right">
                <?php echo date('d') . ' de ' . date('M') . ' de ' . date('Y');?>
            </div>
        </footer>
    </div>
</div>
<!-- General JS Scripts -->
<?php include '../../footer.php'; ?>

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