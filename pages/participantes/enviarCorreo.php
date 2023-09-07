<?php
include '../../config.php';
include '../../services/MailerService.php';

$mailService = new MailerService();
$correo = $_REQUEST["correo"];
echo $mailService->construirCorreo($db,$correo,'prueba?');
