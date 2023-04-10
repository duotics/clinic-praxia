<?php include('../../init.php');
$dM = $Auth->vLogin('COMP');
$brdItems = array(array("nom" => "Sistema"));
$objBrc = new App\Core\genInterfaceBreadc($brdItems, TRUE, "Componentes");
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php');
sLOG('sw');
?>
<div class="container">
  <?php echo $objBrc->render(); ?>
  <?php include('_index.php'); ?>
</div>
<?php include(root['f'] . 'foot.php') ?>