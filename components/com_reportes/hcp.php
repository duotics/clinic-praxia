<?php include('../../init.php');
$dM=$Auth->vLogin('REPHCP');
include(root['f']."head.php");?>
<body>
<?php include(root['m'].'mod_menu/menuMain.php');?>
<div class="container">
	<?php echo genHeader($dM,'page-header') ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientes_list.php'); ?></div>
</div>
<?php include(root['m'].'mod_taskbar/taskb_consultas.php'); ?>
<?php include(root['f'].'footer.php')?>