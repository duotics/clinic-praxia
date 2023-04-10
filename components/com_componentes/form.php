<?php include('../../init.php');
$dM = $Auth->vLogin('COMP');
$itemsBrd = array(
  array("nom" => "Sistema"),
  array("nom" => "Componentes", "link" => route['c'] . "com_componentes/")
);
$objBrc = new App\Core\genInterfaceBreadc($itemsBrd, TRUE, "Componentes");
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php');
sLOG('sw');
?>
<div class="container">
  <?php $objBrc->render()  ?>
  <?php include('_form.php') ?>
</div>
<?php include(root['f'] . 'foot.php'); ?>