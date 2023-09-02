<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \PHPMailer\PHPMailer\SMTP;

class MailerService
{
    protected  $identificador, $sender, $usernameSmtp, $passwordSmtp, $host, $port, $senderName, $destinatario;

    public function __construct()
    {
        $this->sender = $_ENV["EMAIL_SMTP"];
        $this->usernameSmtp = $_ENV["USERNAME_SMTP"];
        $this->passwordSmtp = $_ENV["PASSWORD_SMTP"];
        $this->host = $_ENV["HOST_SMTP"];
        $this->port = $_ENV["PORT_SMTP"];
    }

    public function construirCorreo($destinatario)
    {
        $this->destinatario = $destinatario;
        $this->senderName = 'BANDRANK';
        $asunto = "Comprobante de calificación de concurso";
        $html = $this->templateHtml();
        $adjunto = 'exportes/planilla_correo.pdf';
        $_REQUEST["enviar_planilla"] = "si";
        //include __DIR__.'/../pages/participantes/exportes/generarPlanilla.php?planilla=3&banda=3';
        $nombreArchivo = null;

        $envio = $this->enviarCorreo($asunto, $html, $nombreArchivo);

        if ($envio["statusEmail"] == '200') {
            return true;
        } else {
            return false;
        }
    }

    public function enviarCorreo($asunto, $bodyHtml, $adjunto = null)
    {
        //echo $_ENV["EMAIL_SMTP"];
        //echo $_ENV["USERNAME_SMTP"];
        //echo $_ENV["PASSWORD_SMTP"];
        //echo $_ENV["HOST_SMTP"];
        //echo $_ENV["PORT_SMTP"];
        //exit();
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
            $mail->addAddress( 'natagarge@gmail.com' );
            //$mail->addReplyTo('towho@example.com', 'John Doe';
            $mail->isHTML(true);
            $mail->Subject = "PHPMailer SMTP test";
            $mail->Body = 'Mail body in HTML';
            $mail->AltBody = 'This is the plain text version of the email content';
            if(!$mail->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }else{
                echo 'Message has been sent';
            }

            // Specify the SMTP settings.
            //$mail->isSMTP();
            //$mail->setFrom($this->sender, $this->senderName);
            //$mail->Username   = $this->usernameSmtp;
            //$mail->Password   = $this->passwordSmtp;
            //$mail->Host       = $this->host;
            //$mail->Port       = $this->port;
            //$mail->SMTPAuth   = true;
            //$mail->SMTPSecure = 'tls';
            ////  $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
            //$mail->CharSet = 'UTF-8';
            //$mail->addAddress( $this->destinatario );
            //$mail->isHTML(true);
            //$mail->Subject    = $asunto;
            //$mail->Body       = $bodyHtml;
            //$mail->AltBody    = "";
            //if( $adjunto != null){
            //    $mail->AddAttachment($adjunto);
            //}
            //$mail->Send();
        //    return ["statusEmail" => "200", 'resp' => 'Operación exitosa'];
        //} catch (phpmailerException $e) {
        //    return ["statusEmail" => "400", "resp" => "Error message: " . $e->errorMessage() . "\n"];
        //} catch (Exception $e) {
        //    return ["statusEmail" => "400", "resp" => "Error message: " . $mail->ErrorInfo . "\n"];
        //}
    }

    private function templateHtml()
    {
        return '
        <!doctype html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Simple Transactional Email</title>
            <style>
                /* -------------------------------------
                    INLINED WITH htmlemail.io/inline
                ------------------------------------- */
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table[class=body] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;
                    }
        
                    table[class=body] p,
                    table[class=body] ul,
                    table[class=body] ol,
                    table[class=body] td,
                    table[class=body] span,
                    table[class=body] a {
                        font-size: 16px !important;
                    }
        
                    table[class=body] .wrapper,
                    table[class=body] .article {
                        padding: 10px !important;
                    }
        
                    table[class=body] .content {
                        padding: 0 !important;
                    }
        
                    table[class=body] .container {
                        padding: 0 !important;
                        width: 100% !important;
                    }
        
                    table[class=body] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;
                    }
        
                    table[class=body] .btn table {
                        width: 100% !important;
                    }
        
                    table[class=body] .btn a {
                        width: 100% !important;
                    }
        
                    table[class=body] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;
                    }
                }
        
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                        width: 100%;
                    }
        
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;
                    }
        
                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    }
        
                    .btn-primary table td:hover {
                        background-color: #34495e !important;
                    }
        
                    .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important;
                    }
                }
            </style>
        </head>
        <body class=""
              style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
        <table border="0" cellpadding="0" cellspacing="0" class="body"
               style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
            <tr>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                <td class="container"
                    style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                    <div class="content"
                         style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
                        <!-- START CENTERED WHITE CONTAINER -->
                        <span class="preheader"
                              style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Env&iacute;o de documentos electr&oacute;nicos.</span>
                        <table class="main"
                               style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 5px;border: 2px solid #145A32;">
                            <!-- START MAIN CONTENT AREA -->
                            <tr>
                                <td class="wrapper"
                                    style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                    <table border="0" cellpadding="0" cellspacing="0"
                                           style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                <h2 style="text-align: center; font-family: Calibri; font-size: 24px; color: #145A32">Notificaci&oacute;n de documentos electr&oacute;nicos</h2>
                                                <hr style="background: #145A32; height: 2px; border: none">
                                                <p style="font-family: Calibri; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                                    Estimado(a) cliente <b style="color: #145A32"></b></p>
                                                <p style=" font-family: Calibri; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
                                                    Usted ha recibio un documento electr&oacute;nico por parte de <b style="color: #145A32;"></b> el d&iacute;a
                                                    </p>
                                                <p style="font-family: Calibri; text-align: center; font-size: 12px; color: #626567">Factura elaborada a trav&eacute;s de Sipe. Si deseas esta funcionalidad <a style="color: #145A32; font-family: Calibri; font-weight: bold" href="https://sipe.com.co/">Cont&aacute;ctanos</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- START FOOTER -->
                        <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                            <table border="0" cellpadding="0" cellspacing="0"
                                   style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                <tr>
                                    <td class="content-block"
                                        style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block powered-by"
                                        style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                         
                                    </td>
                                </tr>
                            </table>
                        </div>
        
                    </div>
                </td>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
            </tr>
        </table>
        </body>
        </html>
        ';
    }
}
