<?php include('../../init.php');
$idPac = "-1";
if (isset($_GET['idPac'])) $idPac = $_GET['idPac'];
$detPac=dataPac($idPac);
?>
<div>
	<div><h1><?php echo $detPac['pac_nom']." ".$detPac['pac_ape']; ?></h1></div>
</div>

<body bgcolor="#FFFFFF">
<table align="center">
	<tr>
    	<td>OCn FOto<?php echo $detPac['pac_cod']; ?></td>
  </tr>
  <tr>
  	<td align="center"><a href="<?php echo $detPac['../../pac_image']; ?>" rel="shadowbox">
    <img src="<?php fncImgExist($pathimag_db_pac,lastImgPac($detPac['pac_cod'])) ; ?>" class="detMinPacI" style="max-width:300px; max-height:250px;"/></a></td>
  </tr>
</table>
<table class="bord_gray_4cornes" align="center">
	<tr>
    <td rowspan="4">-</td>
   	  <td>Nombre:</td>
        <td></td>
  </tr>
    <tr>
   	  <td>Dirección:</td>
        <td><?php echo $detPac['pac_dir']; ?></td>
  </tr>
    <tr>
   	  <td>Teléfono:</td>
        <td><?php echo $detPac['pac_tel1']; ?> :: <?php echo $detPac['pac_tel2']; ?></td>
  </tr>
    <tr>
   	  <td>Trabajo:</td>
        <td>&nbsp;</td>
  </tr>
</table>
</body>