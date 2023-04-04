<?php include('../_config.php'); ?>
<?php require_once('../../Connections/conn.php'); ?>
<?php
$colname_RS_emp_sel = "-1";
if (isset($_POST['emp_sel_find'])) {
  $colname_RS_emp_sel = $_POST['emp_sel_find'];
}

$query_RS_emp_sel = sprintf("SELECT * FROM db_empleados WHERE emp_cod = %s", SSQL($colname_RS_emp_sel, "int"));
$RS_emp_sel = mysqli_query(conn, $query_RS_emp_sel) or die(mysqli_error(conn));
$row_RS_emp_sel = mysqli_fetch_assoc($RS_emp_sel);
$totalRows_RS_emp_sel = mysqli_num_rows($RS_emp_sel);
?>
<?php
session_start();
$_SESSION['id_emp'] = null;
$_SESSION['id_emp'] = $row_RS_emp_sel['emp_cod'];
?>
<table class="bord_gray_4cornes" align="center">
  <tr>
    <td rowspan="3" style="padding-right:6px;"><img src="<?php fncImgExist($pathimag_db_emp, $row_RS_emp_sel['emp_img']); ?>" height="110" class="img_form_pac_min" /></td>
    <td>Nombre:</td>
    <td><?php echo $row_RS_emp_sel['emp_nom']; ?> <?php echo $row_RS_emp_sel['emp_ape']; ?></td>
    <td rowspan="5" valign="bottom"><a onclick="$('#cont_emp').slideUp();">UP</a></td>

  </tr>
  <tr>
    <td>Dirección:</td>
    <td><?php echo $row_RS_emp_sel['emp_dir']; ?></td>
  </tr>
  <tr>
    <td>Teléfono:</td>
    <td><?php echo $row_RS_emp_sel['emp_tel1']; ?>. <?php echo $row_RS_emp_sel['emp_tel2']; ?></td>
  </tr>
</table>
<?php
mysqli_free_result($RS_emp_sel);
?>