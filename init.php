<?php
if (!isset($_SESSION)) session_start();
define('_JEXEC', 1); // Este define una constante
ini_set('error_reporting', E_ALL);
$root = __DIR__;
$rootP = dirname(__DIR__, 1);
require $root . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include("config/config.php");

use App\Core\Database;
use App\Core\Auth;
use App\Core\Audit;

$db         =   new Database;
$Auth       =   new Auth;
$AUD       =   new Audit;

$vD = FALSE;
$LOG = null;
$LOGd = null;
