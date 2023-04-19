<?php
//Paths server
define('rootM', $rootM . '/'); //Main Folder App, init.php file is set
define('rootP', $rootP . '/'); //Parent Main Folder App, init.php file is set
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
define('routeP', $_ENV['APP_URLR']); //Main URL App, defined in .env
define('routeM', $_ENV['APP_URL']); //Parent Main URL App, defined in .env
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
$route = route;
