<?php include('../../init.php');

$_SESSION['MODSEL']="EXA";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(root['f']."head.php");
sLOG('g');?>
<body>
<?php include(root['m'].'mod_menu/menuMain.php'); ?>
<div class="container">
    <div><?php include('gest_exa.php'); ?></div>
</div>
<?php include(root['f'].'footer.php')?>