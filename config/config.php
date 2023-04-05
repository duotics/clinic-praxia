<?php
require('paths.php'); //RUTAS de acceso a lugares del framework

date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL, "es_EC");

define("cfg", $cfg = startConfigs("cfg"));
define("cfgBg", $cfgBg = startConfigs("cfgBg"));

$sdate = date('Y-m-d');
$sdatet = date('Y-m-d H:i:s');

$sys['date'] = date('Y-m-d');
$sys['datet'] = date('Y-m-d H:i:s');
$sys['time'] = date('H:i:s');
define('sys', $sys);
$dU=$_SESSION['dU'] ?? null;
define('dU', $dU);
$_SESSION['conf']['theme'] = $_SESSION['du']['THEME'] ?? $_ENV['SYS_THEME'] ?? "zephyre";
