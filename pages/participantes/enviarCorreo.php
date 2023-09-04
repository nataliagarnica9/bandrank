<?php
include '../../config.php';
include '../../services/MailerService.php';

$mailService = new MailerService();
$mailService->construirCorreo('natagarge@gmail.com');