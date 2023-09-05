<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \PHPMailer\PHPMailer\SMTP;

class MailerService
{
    protected  $identificador, $sender, $usernameSmtp, $passwordSmtp, $host, $port, $senderName;

    public function __construct()
    {
        $this->sender = $_ENV["EMAIL_SMTP"];
        $this->usernameSmtp = $_ENV["USERNAME_SMTP"];
        $this->passwordSmtp = $_ENV["PASSWORD_SMTP"];
        $this->host = $_ENV["HOST_SMTP"];
        $this->port = $_ENV["PORT_SMTP"];
    }

    public function construirCorreo($destinatario, $banda = 1)
    {
        $this->senderName = 'BANDRANK';
        $asunto = "Comprobante de calificación de concurso";
        $html = $this->templateHtml();
        $nombreArchivo = 'planilla_'.$banda;
        include __DIR__.'/../pages/participantes/exportes/generarPlanilla.php?planilla=1&banda=6?enviar_planilla=si';
        $adjunto = __DIR__.'/../pages/participantes/exportes/planilla_correo.pdf';
        $envio = $this->enviarCorreo($destinatario, $asunto, $html, $adjunto);

        if ($envio["statusEmail"] == '200') {
            return true;
        } else {
            return false;
        }
    }

    public function enviarCorreo($destinatario,$asunto, $bodyHtml, $adjunto = null)
    {

        $mail = new PHPMailer();
        //try {
            $mail->isSMTP();
            $mail->Username   = $this->usernameSmtp;
            $mail->Password   = $this->passwordSmtp;
            $mail->Host       = $this->host;
            $mail->Port       = $this->port;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';
            $mail->setFrom($this->sender);
            $mail->addAddress($destinatario);
            //$mail->addCC('dgomez@guardiadorada.com');
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $bodyHtml;
            $mail->AltBody = '';
            if( $adjunto != null){
                $mail->AddAttachment($adjunto, 'banda11.pdf');
            }
            if(!$mail->send()){
                return ["statusEmail" => "400", 'resp' => $mail->ErrorInfo];
            }else{
                return ["statusEmail" => "200", 'resp' => 'Operación exitosa'];
            }
    }

    private function templateHtml()
    {
        // necesito el nombre del instructor, de la banda y del concurso
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Comprobante de Calificación</title>
            <style>
                .email-container {
                    background: #FF751F; 
                    padding: 20px; 
                    text-align: center;
                    border-radius: 5px;
                }
            
                /* Estilo para el logotipo */
                .logo {
                    display: block;
                    margin: 0 auto;
                    max-width: 300px; 
                }
            
            
                /* Estilos globales */
                body {
                    font-family: "Segoe UI", sans-serif;
                    background-color: #FFFFFF;
                    margin: 0;
                    padding: 0;
                    color: #333; /* Color de texto principal */
                }
            
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
            
                /* Encabezado */
                h1 {
                    font-size: 24px;
                    color: #000; /* Color de encabezado personalizado */
                }
            
                /* Contenido */
                p {
                    font-size: 16px;
                }
            
                ul {
                    list-style-type: none;
                    padding: 0;
                }
            
                li {
                    margin-bottom: 10px;
                }
            
                /* Enlaces */
                a {
                    color: #FF751F; /* Color de enlaces personalizado */
                    text-decoration: none;
                }
            
                /* Botones */
                .btn {
                    display: inline-block;
                    padding: 10px 20px;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 1.5;
                    color: #FFFFFF;
                    text-align: center;
                    text-decoration: none;
                    border: none;
                    border-radius: 5px;
                    transition: background-color 0.15s ease-in-out;
                }
            
                .btn-primary {
                    background-color: #FF751F; /* Color de botón personalizado */
                }
            
                .btn-primary:hover {
                    background-color: #C75A15; /* Color de botón al pasar el ratón */
                }
            
                .body-container {
                    border: 2px solid #DCDCDC;
                    border-radius: 5px;
                    padding: 20px;
                }
            
                /* Pie de página */
                .footer {
                    text-align: center;
                    font-size: 14px;
                    color: #737373; /* Color de texto del pie de página */
                }
            </style>
        </head>
            
        <body>
            
                <div class="container email-container">
                    <img src="https://guardiadorada.com/bandrank/dist/images/bandrank_logotipo_blanco.png" alt="Logotipo BandRank" class="logo">
                </div>
            
            <div class="container">
                <div class="body-container">
                    <h1>Comprobante de calificación</h1>
                    <p style="font-weight: bold;">Hola! Aquí te enviamos el comprobante de la calificación</p>

                    <p>
                        Se ha generado la calificación de la participación de tu agrupación en el concurso ...
                        <br>
                        Puedes descargarla a continuación :)
                    </p>
            
                    <p>Gracias por su participación. Si tiene alguna pregunta o necesita más información, no dudes en ponerte en contacto con nosotros.</p>
                    <hr style="border: 1px solid #FF751F;width: 400px;">
                    <p>Atentamente,<br>El equipo BandRank</p>
                </div>
            </div>
            
            <div class="footer">
                © 2023 BandRank. Todos los derechos reservados.
            </div>
        </body>
        </html>
        ';
    }
}
