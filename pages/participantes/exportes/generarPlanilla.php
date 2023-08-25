<?php
include_once('../../../config.php');
require_once('../../../vendor/autoload.php');
require_once('Planilla.php');

use Dompdf\Dompdf;

$id_planilla = $_POST["planilla"];
$id_banda = $_POST["banda"];

$dompdf = new Dompdf();
$planilla = new PlanillaExporte($db, $_SESSION["ID_CONCURSO"], $id_banda, $id_planilla, $_SESSION["ID_USUARIO"]);

ob_start();
$planilla->render();
$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$canvas = $dompdf->getCanvas();
//$canvas->page_text(280, 770, "Página: {PAGE_NUM} de {PAGE_COUNT}", 'helvetica', 8, array(0,0,0));
$pdf = $dompdf->output();
$filename = "planilla.pdf";
file_put_contents($filename, $pdf);
$dompdf->stream($filename, array("Attachment" => 0));