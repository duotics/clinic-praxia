<?php include('../../init.php');
$dM = $Auth->vLogin('MENUCONTENT');
$brdItems = array(array("nom" => $cfg['i']['config']));
$objBrc = new App\Core\genInterfaceBreadc($brdItems, TRUE, "breadcrumb breadcrumb-sm");
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php');
echo sLOG('sw');
?>
<div class="container">
  <?php $objBrc->showInterface(); ?>
  <?php include('_index.php'); ?>
</div>
<?php include(root['f'] . 'foot.php') ?>