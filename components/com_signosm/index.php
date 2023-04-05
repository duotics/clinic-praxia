<?php include('../../init.php');
$dM=fnc_datamod('SIGM');
$css['body']='cero';
include(root['f'].'head.php');
?>
<div class="container-fluid">
	<?php echo genHeader($dM,'page-header')?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>

    <?php include('_index.php') ?>

	<div><?php //include(RAIZc.'com_pacientes/pacientes_list.php'); ?></div>
</div>
<?php include(root['f'].'footer.php') ?>