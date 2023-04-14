<?php require('../../init.php');
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$ide = $_GET['ide'] ?? $_POST['ide'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
if ($acc == md5('DELe')) header(sprintf("Location: %s", "_fncts.php?ide=$ide&acc=$acc"));

$css['body'] = 'cero';
include(root['f'] . 'head.php'); ?>
<?php sLOG('g'); ?>
<?php include('_examenForm.php'); ?>
<?php include(root['f'] . 'footerC.php'); ?>