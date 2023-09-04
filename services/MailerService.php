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
        include __DIR__.'/../pages/participantes/exportes/generarPlanilla.php?planilla=3&banda=3?enviar_planilla=si';
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
        return '
        <!doctype html>
        <html>
        
        </html>
        ';
    }
}
