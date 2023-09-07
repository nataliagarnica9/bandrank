<?php
require_once(__DIR__.'/../../../config.php');

class PlanillaExporte {
    protected $db;
    protected $id_banda;
    protected $id_concurso;
    protected $id_planilla;
    protected $id_jurado;


    function __construct($db, $id_concurso, $id_banda, $id_planilla)
    {
        $this->db = $db;
        $this->id_concurso = $id_concurso;
        $this->id_banda = $id_banda;
        $this->id_planilla = $id_planilla;
    }

    protected function getConcurso() {
        $sel_concurso = $this->db->prepare("SELECT co.*, cc.nombre_categoria
                                            FROM concurso co
                                                     INNER JOIN categorias_concurso cc on co.id_concurso = cc.id_concurso
                                            WHERE co.id_concurso = ?");
        $sel_concurso->bindValue(1, $this->id_concurso);
        $sel_concurso->execute();
        $fetch_concurso = $sel_concurso->fetch(PDO::FETCH_OBJ);

        return $fetch_concurso;
    }

    protected function getBanda() {
        $sel_banda = $this->db->prepare("SELECT * FROM banda WHERE id_banda = ?");
        $sel_banda->bindValue(1, $this->id_banda);
        $sel_banda->execute();
        $fetch_banda = $sel_banda->fetch(PDO::FETCH_OBJ);

        return $fetch_banda;
    }

    protected function getEncabezadoPlanilla() {
        $sel_encabezado = $this->db->prepare("SELECT * FROM encabezado_calificacion WHERE id_planilla = ? AND id_banda = ?");
        $sel_encabezado->bindValue(1, $this->id_planilla);
        $sel_encabezado->bindValue(2, $this->id_banda);
        $sel_encabezado->execute();
        $fetch_encabezado = $sel_encabezado->fetch(PDO::FETCH_OBJ);

        return $fetch_encabezado;
    }

    protected function getPlanilla() {
        $sel_planilla = $this->db->prepare("SELECT * FROM planilla WHERE id_planilla = ?");
        $sel_planilla->bindValue(1, $this->id_planilla);
        $sel_planilla->execute();
        $fetch_planilla = $sel_planilla->fetch(PDO::FETCH_OBJ);

        return $fetch_planilla;
    }

    protected function getJurado() {
        $encabezado = $this->getEncabezadoPlanilla();

        $sel_jurado = $this->db->prepare("SELECT * FROM jurado WHERE id_jurado = ?");
        $sel_jurado->bindValue(1, $encabezado->id_jurado);
        $sel_jurado->execute();
        $fetch_jurado = $sel_jurado->fetch(PDO::FETCH_OBJ);

        return $fetch_jurado;
    }

    protected function getDetallesCalificacion() {
        $encabezado = $this->getEncabezadoPlanilla();

        $sel_detalles = $this->db->prepare("SELECT d.id_calificacion, d.id_criterioevaluacion, d.puntaje, c.nombre_criterio, c.rango_calificacion
                                          FROM detalle_calificacion d
                                                   INNER JOIN criterio c
                                                              ON d.id_criterioevaluacion = c.id_criterio
                                          WHERE d.id_calificacion = ?");
        $sel_detalles->bindValue(1, $encabezado->id_calificacion);
        $sel_detalles->execute();
        $fetch_detalles = $sel_detalles->fetchAll(PDO::FETCH_OBJ);

        return $fetch_detalles;
    }

    protected function generarEncabezado(){
        $html = '
        <html lang="es">
            <body>
            <header>
            <table class="informacion" style="padding: 0px" border="0">
                <tr>
                    <td>
                        <img src="https://guardiadorada.com/bandrank/dist/images/logo_concurso_general_santander.png" style="width:200px;">
                    </td>
                    <td>
                        <img src="https://guardiadorada.com/bandrank/dist/images/bandrank_logotipo.png" style="width:200px;margin-left:300px">
                    </td>
                </tr>
                <tr style="padding: 0px; height:100px">
                    <td style="padding: 0px"> </td>
                    <td style="padding: 0px 5px 0px 450px;font-weight: bold">'. $this->getPlanilla()->nombre_planilla.'</td>
                </tr>
            </table>
            </header>';
            return $html;
    }

    protected function generarDatos() {
        
        $html='
            <table class="informacion-datos" style="padding: 5px;margin-top: 30px;" border="0">
                <tr>
                    <td style="width: 30%;padding: 5px; font-weight: bold"><label for="nombre_banda">Nombre de la banda:</td>
                    <td style="border-bottom: 1px solid #000;padding: 5px">'. $this->getBanda()->nombre.'  </td>
                </tr>
                <tr>
                    <td style="width: 30%;padding: 5px; font-weight: bold"><label for="lugar">Lugar de procedencia:</td>
                    <td style="border-bottom: 1px solid #000;padding: 5px">'. $this->getBanda()->ubicacion.'</td>
                </tr>
                <tr>
                    <td style="width: 30%;padding: 5px; font-weight: bold"><label for="jurado">Jurado:</td>
                    <td style="border-bottom: 1px solid #000;padding: 5px">'. $this->getJurado()->nombres.' '.$this->getJurado()->apellidos.'</td>
                </tr>
                <tr>
                    <td style="width: 30%;padding: 5px; font-weight: bold"><label for="concurso">Concurso:</td>
                    <td style="border-bottom: 1px solid #000;padding: 5px">'. $this->getConcurso()->nombre_concurso.'</td>
                </tr>
            </table>';
            return $html;
    }

    protected function generarDetalles(){
            $encabezado = $this->getEncabezadoPlanilla();
            $detalles = $this->getDetallesCalificacion();
            $concurso = $this->getConcurso();

            $detalles_calificacion = "";

            foreach($detalles as $detalle) {
                $detalles_calificacion .= '
                <tr>
                    <td style="padding: 3px;border: 1px solid #DCDCDC">'.$detalle->nombre_criterio.'</td>
                    <td style="padding: 3px;text-align:center; border: 1px solid #DCDCDC">0-'.$detalle->rango_calificacion.'</td>
                    <td style="padding: 3px;text-align:center; border: 1px solid #DCDCDC">'.$detalle->puntaje.'</td>
                </tr>
                ';
            }


            $html = '
            <table class="informacion" style="margin-top: 10px" border="0">
                <tr>
                    <th class="red-text">Aspectos a evaluar</th>
                    <th class="red-text">Rango</th>
                    <th class="red-text">Valoración</th>
                </tr>
                '.$detalles_calificacion.'
                <tr>
                    <td style="padding: 3px;font-size: 11px; border: 1px solid #DCDCDC">
                        <p>
                            Modalidad: '.$concurso->nombre_categoria.'
                        </p>
                    </td>
                    <td style="padding: 3px;text-align:center; border: 1px solid #DCDCDC; font-weight: bold">Parcial total</td>
                    <td style="padding: 3px;text-align:center; border: 1px solid #DCDCDC">'.$encabezado->total_calificacion.'</td>
                </tr>   
            </table>

        <table class="informacion" style="margin-top: 10px;">
            <tr>
                <th colspan="2" class="red-text">
                    Observaciones generales
                </th>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #DCDCDC;padding: 3px 5px">
                    '.$encabezado->observaciones.'
                </td>
            </tr>
        </table>

        <table class="informacion" style="margin-top: 10px; border 1px solid #DCDCDC">
            <tr>
                <td colspan="2" style="font-size: 10px">
                    * La firma del instructor, sobrentiende la aceptación de la valoración otorgada y no da cabida a apelaciones
                    posteriores a su entrega a la organización.
                </td>
            </tr>
        </table>
        <table class="informacion" style="margin-top: 20px; border 1px solid #DCDCDC">  
            <tr>
                <td style="width:50%">
                    <img src="https://guardiadorada.com/bandrank/dist/images/firmas/Firma.png" style="width: 250px; margin-left: 25px;margin-right: 25px;">
                    <hr style="width: 70%;background:#FFF">
                    <p style="text-align:center;font-weight: bold">Firma jurado</p>
                </td>
                <td style="width:50%">
                    <img src="https://guardiadorada.com/bandrank/dist/images/firmas/Firma.png" style="width: 250px; margin-left: 25px;margin-right: 25px;">
                    <hr style="width: 70%;background:#FFF">
                    <p style="text-align:center;font-weight: bold">Firma instructor</p>
                </td>
            </tr>
        </table> 

        <table class="informacion" style="margin-top: 100px; border 1px solid #DCDCDC">  
            <tr>
                <td style="width:10%">
                    <img src="https://guardiadorada.com/bandrank/dist/images/logo_buc.png" style="width: 50px; margin-left: 25px;margin-right: 25px;">
                </td>
                <td style="width:10%">
                    <img src="https://guardiadorada.com/bandrank/dist/images/escudo_colegio.png" style="width: 50px; margin-left: 25px;margin-right: 25px;">
                </td>
                <td style="width:80%"></td>
            </tr>
        </table> 
        </body>
        </html>';
        return $html;
    }

    protected function crearEstilos()
    {
        $estilos = "<style>
            @page {
                margin-top: 0.5em;
                margin-left: 1.6em;
                margin-right: 0;
                margin-bottom: 0.5em;
            }

            body {
                margin-top: 115px;
            }

            header {
                position: fixed;
                top: 0px;
                left: 0px;
                right: 0px; 
            }

            *{
               color: #273746;
               font-family: sans-serif;
            }    
       
            .logo {
               padding: 0px 90px 0 50px;
            }    
       
            .informacion {
                width: 97%;
                border-collapse: collapse;
                border: 0px;
            }

            .informacion-datos {
                width: 97%;
                border-collapse: collapse;
                border: 0px;
                background:#DCDCDC;
            }
        
            .encabezado {
                background: #EAEDED;
                border-collapse: collapse;
                border-radius: 6px;
                overflow: hidden;
            }

            .red-text {
                background: red;
                color: #FFF;
                text-align: center;
                padding: 5px 0px;
            }
        </style>";
        return $estilos;
    }

    public function render() {
        echo $this->generarEncabezado();
        echo $this->crearEstilos();
        echo $this->generarDatos();
        echo $this->generarDetalles();
    }
}