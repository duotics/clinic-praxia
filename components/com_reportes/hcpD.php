<?php include('../../init.php');
$dM=$Auth->vLogin('REPHCP');
include(root['f']."head.php");?>
<body>
<?php include(root['m'].'mod_menu/menuMain.php');?>
<div class="container">
    <?php include('_hcpD.php') ?>
</div>
<?php include(root['m'].'mod_taskbar/taskb_consultas.php'); ?>
<?php include(root['f'].'footer.php')?>