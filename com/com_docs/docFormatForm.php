<?php require('../../init.php');
$dM=$Auth->vLogin('DOCF');
//$dC=detRow('db_componentes','mod_ref','DOCF');
$id=null;
$acc=null;
if(isset($_REQUEST['id'])) $id=$_REQUEST['id'];
if(isset($_REQUEST['acc'])) $acc=$_REQUEST['acc'];
//$id=$_GET['id'] ?? $_POST['id'] ?? null;
//$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$dExamF=detRow('db_examenes_format','id',$id);//fnc_dataexam($ide);
if($acc=='DELEF'){
	header(sprintf("Location: %s", '_acc.php?ide='.$ide.'&action=DELEF'));
}
include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc?>com_index">Inicio</a></li>
  <li><a href="#">Sistema</a></li>
  <li><a href="docFormat.php">Documentos Formato</a></li>
  <li class="active">Formulario</li>
</ol>
<div class="container-fluid">
	<?php sLOG('t') ?>
	<?php include('_docFormatForm.php') ?>
</div>
<?php include(RAIZf.'footerC.php') ?>