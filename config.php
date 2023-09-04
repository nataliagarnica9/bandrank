<?php
ob_start();
error_reporting(0);
require('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Inicio la session
if(!session_id()){
    session_start();
}

//Defino variables constantes y de uso general
if(!defined('base_url')) define('base_url',$_ENV['BASE_URL']);
if(!defined('DB_SERVER')) define('DB_SERVER',$_ENV["DB_SERVER"]);
if(!defined('DB_USERNAME')) define('DB_USERNAME',$_ENV["DB_USER"]);
if(!defined('DB_PASSWORD')) define('DB_PASSWORD',$_ENV["DB_PASSWORD"]);
if(!defined('DB_NAME')) define('DB_NAME',$_ENV["DB_DATABASE_NAME"]);

//if(!$_SESSION) {
//    header("location:" . base_url . 'inicio.php');
//    exit();
//}

// Creo la conexión a base de datos
try {
    $db = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8', DB_USERNAME, DB_PASSWORD);
    header("Content-type:text/html; charset=utf-8");
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n" . $exc->getTraceAsString();
}

// Configuraciones horarias adicionales
setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Bogota');

ob_end_flush();