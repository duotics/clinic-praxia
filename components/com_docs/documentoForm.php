<?php require('../../init.php');
$dM=$Auth->vLogin('DOCS');
//$dM=$Auth->vLogin();
$acc=null;
$idp=null;
$idc=null;
$idd=null;
$iddf=null;
if(isset($_REQUEST['acc'])) $acc=$_REQUEST['acc'];
if(isset($_REQUEST['idp'])) $idp=$_REQUEST['idp'];
if(isset($_REQUEST['idc'])) $idc=$_REQUEST['idc'];
if(isset($_REQUEST['idd'])) $idd=$_REQUEST['idd'];
if(isset($_REQUEST['iddf'])) $iddf=$_REQUEST['iddf'];
if($acc==md5('DELd')) header(sprintf("Location: %s", '_acc.php?ids='.$idd.'&acc='.md5('DELd').'&accJS=TRUE'));
$css['body']='cero';
include(root['f'].'head.php'); ?>
<div class="container-fluid">
	<?php sLOG('t') ?>
	<?php include('_documentoForm.php') ?>
</div>
<?php include(root['f'].'footerC.php');