<?php
require_once(__DIR__.'/../../../config.php');

class PlanillaExporte {
    protected $db;
    protected $id_banda;
    protected $id_concurso;
    protected $id_planilla;
    protected $id_jurado;


    function __construct($db, $id_concurso, $id_banda, $id_planilla, $id_jurado)
    {
        $this->db = $db;
        $this->id_concurso = $id_concurso;
        $this->id_banda = $id_banda;
        $this->id_planilla = $id_planilla;
        $this->id_jurado = $id_jurado;
    }

    protected function getConcurso() {
        $sel_concurso = $this->db->prepare("SELECT * FROM concurso WHERE id_concurso = ?");
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

    protected function getPlanilla() {
        $sel_planilla = $this->db->prepare("SELECT * FROM planilla WHERE id_planilla = ?");
        $sel_planilla->bindValue(1, $this->id_planilla);
        $sel_planilla->execute();
        $fetch_planilla = $sel_planilla->fetch(PDO::FETCH_OBJ);

        return $fetch_planilla;
    }

    protected function getJurado() {
        $sel_jurado = $this->db->prepare("SELECT * FROM jurado WHERE id_jurado = ?");
        $sel_jurado->bindValue(1, $this->id_jurado);
        $sel_jurado->execute();
        $fetch_jurado = $sel_jurado->fetch(PDO::FETCH_OBJ);

        return $fetch_jurado;
    }

    protected function generarPlanilla(){
        $html = '
        <table>
            <tr>
                <td>
                    
                </td>
                <td>
                    <img src="'.base_url.'dist/images/bandrank_logotipo.png" style="width:100px;">
                </td>
            </tr>
        </table>
        <h5>'. $this->getPlanilla()->nombre_planilla.'</h5>
        <table>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td colspan="2"><label for="nombre_banda">Nombre de la Banda:</label></td>
                            <td>'. $this->getBanda()->nombre.'</td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="lugar">Lugar de Procedencia:</label></td>
                            <td>'. $this->getBanda()->ubicacion.'</td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="jurado">Jurado:</label></td>
                            <td>'. $this->getJurado()->nombres.' '.$this->getJurado()->apellidos.'</td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="concurso">Concurso:</label></td>
                            <td>'. $this->getConcurso()->nombre_concurso.'</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <th class="red-text">Aspectos a Evaluar</th>
                            <th class="red-text">Rango</th>
                            <th class="red-text">Valoración (0-10)</th>
                        </tr>
                        <tr>
                            <td class="red-text">Puntualidad y orden</td>
                            <td class="red-text">0-10</td>
                            <td><input type="number" min="0" max="10" step="0.1" class="form-control"></td>
                        </tr>
                        <tr>
                            <td class="red-text">Uniformidad, presentación</td>
                            <td class="red-text">0-10</td>
                            <td><input type="number" min="0" max="10" step="0.1" class="form-control"></td>
                        </tr>
                        <tr>
                            <td class="red-text">Estado, limpieza</td>
                            <td class="red-text">0-10</td>
                            <td><input type="number" min="0" max="10" step="0.1" class="form-control"></td>
                        </tr>
                        <tr>
                            <th class="red-text">Total</th>
                            <th class="red-text">&nbsp;</th>
                            <th><input type="text" id="total_aspectos" class="form-control" readonly></th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="observation-box">
            <div class="observation-title">Observaciones:</div>
            <textarea class="form-control" name="observaciones" rows="4"></textarea>
        </div>
        <div class="signature-box">
            <div class="signature">
                <div class="signature-title">Firma del Instructor:</div>
                <input type="text-area" class="signature-input">
            </div>
            <div class="signature">
                <div class="signature-title">Firma del Jurado:</div>
                <input type="text-area" class="signature-input">
            </div>
        </div>';
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
                        left: 0px;
                        right: 0px; 
                    }
                    
                   * {
                       color: #273746;
                       font-family: sans-serif;
                   }

                   table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                
                th, td {
                    padding: 10px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                    border-right: 1px solid #ddd;
                }
                
                th {
                    background-color: #ffffff;
                    color: white;
                }
                
                .red-text {
                    color: rgb(0, 0, 0);
                    background-color: #ffffff;
                }
                
                .observation-box {
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    background-color: #f9f9f9;
                    margin-bottom: 20px;
                }
                
                .observation-title {
                    font-weight: bold;
                    margin-bottom: 10px;
                    color: #343a40;
                }
                
                .signature-box {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 20px;
                }
                
                .signature-title {
                    font-weight: bold;
                    margin-bottom: 10px;
                    color: #343a40;
                }
                
                .signature-input {
                    width: 60%;
                    padding: 8px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                </style>";
        return $estilos;
    }

    public function render() {
        echo $this->generarPlanilla();
        echo $this->crearEstilos();
    }
}