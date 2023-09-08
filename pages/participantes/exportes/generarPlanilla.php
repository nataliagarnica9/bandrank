<?php
include_once(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../../../vendor/autoload.php');
require_once('Planilla.php');

use Dompdf\Dompdf;
error_reporting(E_ALL);
$id_planilla = $_REQUEST["planilla"];
$id_banda = $_REQUEST["banda"];

$dompdf = new Dompdf(array('enable_remote' => true));
$planilla = new PlanillaExporte($db, $_SESSION["ID_CONCURSO"], $id_banda, $id_planilla);

ob_start();
$planilla->render();
$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$canvas = $dompdf->getCanvas();
//$canvas->page_text(280, 770, "Página: {PAGE_NUM} de {PAGE_COUNT}", 'helvetica', 8, array(0,0,0));
$pdf = $dompdf->output();

if( isset( $_REQUEST["enviar_planilla"] ) && $_REQUEST["enviar_planilla"] == 'si') {
    $filename = "planilla_correo.pdf";
    file_put_contents($filename, $pdf);
    //$dompdf->stream($filename, array("Attachment" => false));
} else {
    $filename = "planilla.pdf";
    file_put_contents($filename, $pdf);
    $dompdf->stream($filename, array("Attachment" => false));
}
