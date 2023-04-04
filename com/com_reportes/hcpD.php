<?php include('../../init.php');
$dM=$Auth->vLogin('REPHCP');
include(RAIZf."head.php");?>
<body>
<?php include(RAIZm.'mod_menu/menuMain.php');?>
<div class="container">
    <?php include('_hcpD.php') ?>
</div>
<?php include(RAIZm.'mod_taskbar/taskb_consultas.php'); ?>
<?php include(RAIZf.'footer.php')?>