<?php
include '../../config.php';
include '../../services/MailerService.php';

$mailService = new MailerService();
$mailService->enviarCorreo('','');