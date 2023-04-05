<?php require('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$dExamF=detRow('db_examenes_format','id',$id);//fnc_dataexam($ide);
if($acc=='DELEF'){
	header(sprintf("Location: %s", '_fncts.php?ide='.$ide.'&action=DELEF'));
}
$css['body']='cero';
include(root['f'].'head.php'); ?>
<?php sLOG('g') ?>
<div class="container-fluid">
	<?php include('_examenFormatForm.php') ?>
</div>
<?php include(root['f'].'footerC.php') ?>