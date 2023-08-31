<?php
require_once('../../config.php');
$query_concurso = $db->prepare("SELECT * FROM concurso WHERE fecha_evento = ? LIMIT 1");
$query_concurso->bindValue(1, date('Y-m-d', time()));
$query_concurso->execute();
$fetch_concurso = $query_concurso->fetch(PDO::FETCH_OBJ);

$sel_banda = $db->prepare("SELECT * FROM banda WHERE id_concurso = ? AND id_banda = ?");
$sel_banda->bindValue(1, $fetch_concurso->id_concurso);
$sel_banda->bindValue(2, $_SESSION["ID_USUARIO"]);
$sel_banda->execute();
$fetch_banda = $sel_banda->fetch(PDO::FETCH_OBJ);

$sel_planilla = $db->prepare("SELECT * FROM planilla WHERE id_concurso = ?");
$sel_planilla->bindValue(1, $fetch_concurso->id_concurso);
$sel_planilla->execute();
$fetch_planilla = $sel_planilla->fetchAll(PDO::FETCH_OBJ);
?>
<table class="table table-hover table-sm table-bordered mt-5 table-responsive" style="width: max-content;">
    <thead>
        <tr>
            <td rowspan="2"><b>Banda</b></td>
            <?php
            foreach ($fetch_planilla as $planilla) :
                $sel_criterios1 = $db->prepare("SELECT * FROM criterio WHERE id_planilla = ?");
                $sel_criterios1->bindValue(1, $planilla->id_planilla);
                $sel_criterios1->execute();
                $fetch_criterios1 = $sel_criterios1->fetchAll(PDO::FETCH_OBJ);

                $num_planilla = count($fetch_criterios1);

            ?>
                <td class="text-center fw-bold" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" colspan="<?= $num_planilla ?>"><?= $planilla->nombre_planilla ?></td>
            <?php
            endforeach;
            ?>
            <td rowspan="2" class="text-center fw-bold">Totales</td>
        </tr>

        <tr>
            <?php
            foreach ($fetch_planilla as $planilla) :
                $sel_criterios = $db->prepare("SELECT * FROM criterio WHERE id_planilla = ?");
                $sel_criterios->bindValue(1, $planilla->id_planilla);
                $sel_criterios->execute();
                $fetch_criterios = $sel_criterios->fetchAll(PDO::FETCH_OBJ);

                foreach ($fetch_criterios as $criterio) : ?>
                    <td><?= $criterio->nombre_criterio ?></td>


            <?php
                endforeach;
            endforeach;
            ?>
        </tr>
    </thead>
    <?php
    $sum_puntaje = 0;

    ?>
    <tr>
        <td><?= $fetch_banda->nombre ?></td>
        <?php
        foreach ($fetch_planilla as $planilla) :
            $sel_criterios2 = $db->prepare("SELECT * FROM criterio WHERE id_planilla = ?");
            $sel_criterios2->bindValue(1, $planilla->id_planilla);
            $sel_criterios2->execute();
            $fetch_criterios2 = $sel_criterios2->fetchAll(PDO::FETCH_OBJ);

            foreach ($fetch_criterios2 as $criterio) :
                $sel_calificacion = $db->prepare("SELECT dc.puntaje
                                                          FROM encabezado_calificacion ec
                                                                   INNER JOIN detalle_calificacion dc ON ec.id_calificacion = dc.id_calificacion
                                                          WHERE ec.id_banda = ?
                                                            AND ec.id_planilla = ?
                                                            AND dc.id_criterioevaluacion = ? ");
                $sel_calificacion->bindValue(1, $banda->id_banda);
                $sel_calificacion->bindValue(2, $planilla->id_planilla);
                $sel_calificacion->bindValue(3, $criterio->id_criterio);
                $sel_calificacion->execute();
                $fetch_puntaje = $sel_calificacion->fetch(PDO::FETCH_OBJ);

                $sum_puntaje += $fetch_puntaje->puntaje;
        ?>
                <td><?= $fetch_puntaje->puntaje ?></td>
        <?php
            endforeach;
        endforeach;
        ?>
        <td><?= $sum_puntaje ?></td>
    </tr>
    <?php
    $sum_puntaje = 0;
    ?>
</table>