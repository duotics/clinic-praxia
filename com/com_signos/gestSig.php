<?php require_once('../../init.php');
$dM = $Auth->vLogin('SIGVIT');
$css['body'] = 'cero';
include_once(RAIZf . 'head.php') ?>
<div>
	<?php sLOG('t') ?>
	<?php include('_gestSig.php') ?>
</div>
<?php include(RAIZf . 'footerC.php') ?>