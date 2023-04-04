<?php $bsTheme = $_SESSION['dU']['THEME'] ?? $_ENV["APP_THEME"] ?? "zephyre"; ?>
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . 'bootstrap/dist/css/bootstrap.min.css' ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "bootswatch/dist/{$bsTheme}/bootstrap.min.css" ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . '@fortawesome/fontawesome-free/css/all.min.css' ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . 'jquery-ui/dist/themes/base/jquery-ui.min.css' ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . 'jquery-ui/dist/themes/ui-lightness/jquery-ui.min.css' ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "datatables.net-bs5/css/dataTables.bootstrap5.min.css" ?>">
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "select2/dist/css/select2.min.css" ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css" ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "@fancyapps/ui/dist/fancybox/fancybox.css" ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "sweetalert2/dist/sweetalert2.min.css" ?>">
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "animate.css/animate.css" ?>">
<link rel="stylesheet" type="text/css" href="<?php echo route['n'] . "leaflet/dist/leaflet.css" ?>">
<link rel="stylesheet" type="text/css" href="<?php echo route['a'] . "css/custom-v01.css" ?>">