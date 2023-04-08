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
    'm' => rootM . 'modules/',
    's' => rootM . 'system/',
    'p' => rootM . 'api/',
    'r' => rootM . 'resources/',
    'i' => rootM . 'resources/images',
    'f' => rootM . 'resources/frames/',
    't' => rootM . 'resources/templates/'
));
//Paths url
define('routeP', $_ENV['APP_URLR']);
define('routeM', $_ENV['APP_URL']);
define('route', array(
    '0' => routeM,
    'd' => routeM . 'data/',
    'c' => routeM . 'components/',
    'o' => routeM . 'config/',    
    's' => routeM . 'system/',
    'n' => routeM . 'node_modules/',
    'p' => routeM . 'api/',
    'r' => routeM . 'resources/',
    'i' => routeM . 'resources/images/',
    'f' => routeM . 'resources/frames/',
    'a' => routeM . 'resources/assets/',
    't' => routeM . 'resources/templates/'
));

$_SESSION['urlp'] = $_SESSION['urlc'] ?? null;
$_SESSION['urlc'] = basename($_SERVER['SCRIPT_FILENAME']); //URL clean Current;
$urlc = $_SESSION['urlc'];
$urlp = $_SESSION['urlp'];
