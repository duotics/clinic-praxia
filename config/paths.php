<?php
//Paths server
define('rootP', $rootP . '/');
define('rootM', $root . '/');
define('root', array(
    '0' => rootM,
    'a' => rootM . 'assets/',
    'd' => rootM . 'data/',
    'c' => rootM . 'components/',
    'o' => rootM . 'config/',
    'i' => rootM . 'assets/images',
    'm' => rootM . 'modules/',
    'f' => rootM . 'frames/',
    's' => rootM . 'system/',
    'p' => rootM . 'api/',
    'r' => rootM . 'resources/',
    't' => rootM . 'resources/templates/'
));
//Paths url
define('routeP', $_ENV['APP_URLR']);
define('routeM', $_ENV['APP_URL']);
define('route', array(
    '0' => routeM,
    'a' => routeM . 'assets/',
    'd' => routeM . 'data/',
    'c' => routeM . 'components/',
    'f' => routeM . 'frames/',
    'o' => routeM . 'config/',
    'i' => routeM . 'assets/images/',
    's' => routeM . 'system/',
    'n' => routeM . 'node_modules/',
    'p' => routeM . 'api/',
    'r' => routeM . 'resources/',
    't' => routeM . 'resources/templates/'
));

$_SESSION['urlp'] = $_SESSION['urlc'] ?? null;
$_SESSION['urlc'] = basename($_SERVER['SCRIPT_FILENAME']); //URL clean Current;
$urlc = $_SESSION['urlc'];
$urlp = $_SESSION['urlp'];