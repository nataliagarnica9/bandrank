<?php
require_once("../../config.php");

date_default_timezone_set('America/Bogota');

$query_concurso = $db->prepare("SELECT * FROM concurso WHERE fecha_evento = ? LIMIT 1");
$query_concurso->bindValue(1, date('Y-m-d', time()));
$query_concurso->execute();
$fetch_concurso = $query_concurso->fetch(PDO::FETCH_OBJ);

$query_categorias = $db->prepare("SELECT c.id_categoria, c.nombre_categoria, SUM(dc.puntaje) AS puntaje_categoria
FROM encabezado_calificacion ec
         INNER JOIN detalle_calificacion dc
                    ON ec.id_calificacion = dc.id_calificacion
         INNER JOIN banda b ON ec.id_banda = b.id_banda
         INNER JOIN categorias_concurso c ON b.id_categoria = c.id_categoria
         INNER JOIN categoriasxconcurso cc ON c.id_categoria = cc.id_categoria
WHERE cc.id_concurso = ?
GROUP BY c.id_categoria");
$query_categorias->bindValue(1, $fetch_concurso->id_concurso);
$query_categorias->execute();
$fetch_categorias = $query_categorias->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../head.php'; ?>
<title>Resultados - BandRank</title>
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
                    <h1>Resultados</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Premiación</a></div>
                        <div class="breadcrumb-item">Resultados</div>
                    </div>
                </div>
                <div class="section-body">
                    <?php
                    foreach($fetch_categorias as $categoria):

                        // Consulto el total de las calificaciones
                        $sel_puntaje = $db->prepare("SELECT b.nombre                                                                           AS banda_nombre,
                                                                   cc.nombre_categoria                                                                AS categoria_nombre,
                                                                   IFNULL(puntajes.total_puntaje, 0)                                                  AS total_puntaje,
                                                                   IFNULL(penalizaciones.total_penalizacion, 0)                                       AS total_penalizacion,
                                                                   (IFNULL(puntajes.total_puntaje, 0) - IFNULL(penalizaciones.total_penalizacion, 0)) AS puntaje_final,
                                                                   b.nombre_instructor
                                                            FROM banda b
                                                                     INNER JOIN categorias_concurso cc ON b.id_categoria = cc.id_categoria
                                                                     LEFT JOIN (SELECT c.id_banda,
                                                                                       SUM(det.puntaje) AS total_puntaje
                                                                                FROM encabezado_calificacion c
                                                                                         LEFT JOIN detalle_calificacion det ON c.id_calificacion = det.id_calificacion
                                                                                GROUP BY c.id_banda) AS puntajes ON b.id_banda = puntajes.id_banda
                                                                     LEFT JOIN (SELECT c.id_banda,
                                                                                       SUM(pe.puntaje_penalizacion) AS total_penalizacion
                                                                                FROM encabezado_calificacion c
                                                                                         LEFT JOIN detalle_penalizacion dp ON c.id_calificacion = dp.id_calificacion
                                                                                         LEFT JOIN penalizacion pe ON dp.id_penalizacion = pe.id_penalizacion
                                                                                GROUP BY c.id_banda) AS penalizaciones ON b.id_banda = penalizaciones.id_banda
                                                            WHERE cc.id_categoria = ?
                                                            ORDER BY puntaje_final DESC LIMIT 3;");
                        $sel_puntaje->bindValue(1, $categoria->id_categoria);
                        $sel_puntaje->execute();
                        $fetch_puntaje = $sel_puntaje->fetchAll(PDO::FETCH_OBJ);

                        ?>
                        <h2 class="section-title"><?=$categoria->nombre_categoria?></h2>
                        <div class="row">
                            <div class="col-12">
                                <div class="activities">
                                    <?php
                                    $posicion = "";
                                    $bg = "";
                                    foreach($fetch_puntaje as $i => $puntajes):
                                        switch ($i):
                                            case 0:
                                                $posicion = "Primer puesto";
                                                $bg = "#FF751F";
                                                break;
                                            case 1:
                                                $posicion = "Segundo puesto";
                                                $bg = "#1FA9FF";
                                                break;
                                            case 2:
                                                $posicion = "Tercer puesto";
                                                $bg = "#E51FFF";
                                                break;
                                        endswitch;
                                    ?>
                                        <div class="activity">
                                            <div class="activity-icon text-white shadow-primary" style="background: <?=$bg?>">
                                                <i class="fas fa-splotch"></i>
                                            </div>
                                            <div class="activity-detail">
                                                <div class="mb-2">
                                                    <span class="text-job text-primary"><?= $puntajes->banda_nombre ?> de <?= $puntajes->nombre_instructor ?></span>
                                                    <span class="bullet"></span>
                                                    <a class="text-job" href="#"><?=$posicion?></a>
                                                </div>
                                                <p>Con un total de <?= $puntajes->puntaje_final ?> puntos.</p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </div>
            </section>
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
</body>
</html>