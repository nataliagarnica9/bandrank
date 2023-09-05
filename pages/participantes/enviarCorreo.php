<?php
include '../../config.php';
include '../../services/MailerService.php';

$mailService = new MailerService();
$mailService->construirCorreo('stevenson0605@gmail.com');