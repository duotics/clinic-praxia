<?php require('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$dExamF=detRow('db_examenes_format','id',$id);//fnc_dataexam($ide);
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<div class="container">
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $dExamF['nom'] ?></h3>
    </div>
    <div class="panel-body">
		<?php echo $dExamF['des'] ?>
    </div>
</div>
</div>
<?php include(RAIZf.'footerC.php') ?>