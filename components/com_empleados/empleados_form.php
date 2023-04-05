<?php include('../../init.php');
if (($_GET['id_emp']==null)&&($_GET["action_form"]!="INSERT")) $_GET['id_emp']=$_SESSION['id_emp'];
$accion =$_GET["action_form"];
$rowMod=fnc_datamod($_SESSION['MODSEL']);
$query_empleado ='SELECT * FROM db_empleados INNER JOIN db_types ON db_empleados.typ_cod = db_types.typ_cod WHERE db_empleados.emp_cod="'.$_GET['id_emp'].'"';
$RS_empleado = mysqli_query(conn,$query_empleado);
$row_RS_empleado = mysqli_fetch_assoc($RS_empleado);
$query_typ ="SELECT * FROM db_types WHERE typ_ref='TIPEMP' ORDER BY typ_val ASC";
$RS_typ = mysqli_query(conn,$query_typ);
$row_RS_typ = mysqli_fetch_assoc($RS_typ);
include(root['f'].'head.php');
?>
<body class="cero">
<div class="container">

<div class="page-header"><h1><?php echo strtoupper($rowMod['mod_des']); ?></h1></div>
<?php vLOG(); ?>
  <div id="formcont">
   <form enctype="multipart/form-data" id="form_emp" action="_fncts.php" method="post">
   <input name="action_form" type="hidden" id="action_form" value="<?php echo $accion;?>" />
   <input name="txt_cod_emp" type="hidden" id="txt_cod_emp" value="<?php echo $row_RS_empleado['emp_cod'];?>"/>
   <table align="center">
   <tr>
   <td>
   <div style="width:250px; height:190px;">
    <a href="<?php fncImgExist($pathimag_db_emp,$row_RS_empleado['emp_img']);?>" rel="shadowbox"><img src="<?php fncImgExist($pathimag_db_emp,$row_RS_empleado['emp_img']);?>" height="130" class="img_form_emp"/></a>
    <input name="userfile" type="file" class="txt_values-sec" id="userfile" size="0" />
   </div>
   </td>
   <td>
   <div id="form_sec" align="center">
		  <div id="seccf_data">   
            <p>Cedula/RUC</p>
            <div><span id="sprytextfield1"><input type="text" name="txt_ced_emp" value="<?php echo $row_RS_empleado['emp_ced'];?>"/></span></div>
            </div>
		    <div id="seccf_data">     
            <p>Nombres</p>
            <div><span id="sprytextfield2"><input type="text" name="txt_nom_emp" value="<?php echo $row_RS_empleado['emp_nom'];?>"/></span></div>
            </div>
			<div id="seccf_data">   
            <p>Apellidos</p>
            <div><span id="sprytextfield3"><input type="text" name="txt_ape_emp" value="<?php echo $row_RS_empleado['emp_ape'];?>"/></span></div>
            </div>    
            <div id="seccf_data">  
            <p>Direccion</p>
            <div><span id="sprytextfield6"><input type="text" name="txt_dir_emp" value="<?php echo $row_RS_empleado['emp_dir'];?>"/></span></div>
            </div>
            <div id="seccf_data">   
             <p>Telefono 1</p>
            <div><input type="text" name="txt_tel1_emp" value="<?php echo $row_RS_empleado['emp_tel1'];?>"/></div>
            </div>   
            <div id="seccf_data">    
             <p>Telefono 2</p>
              <div><input type="text" name="txt_tel2_emp" value="<?php echo $row_RS_empleado['emp_tel2'];?>"/></div>
            </div>
            <div id="seccf_data">   
              <p>Tipo</p>
            <div>
             <select name="txt_tip_emp" id="txt_tip_emp">
             <option value="-1" <?php if (!(strcmp(-1, $row_RS_empleado['typ_val']))) {echo "selected=\"selected\"";} ?>>Seleccione Tipo Empleado</option>
             <option value="0" <?php if (!(strcmp(0, $row_RS_empleado['typ_val']))) {echo "selected=\"selected\"";} ?>>No Determinado</option>
			<?php
			 do { ?>
             <option value="<?php echo $row_RS_typ['typ_cod']?>"<?php if (!(strcmp($row_RS_typ['typ_val'], $row_RS_empleado['typ_val']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_typ['typ_val']?></option>
                            <?php
} while ($row_RS_typ = mysqli_fetch_assoc($RS_typ));
  $rows = mysqli_num_rows($RS_typ);
  if($rows > 0) {
      mysqli_data_seek($RS_typ, 0);
	  $row_RS_typ = mysqli_fetch_assoc($RS_typ);
  }
?>   </select>
            
  </div>
  </td>
  <td>
 <div id="seccf_data">   
 <div><input type="submit" value="<?php if($accion=='UPDATE'){echo 'Actualizar';}else {if($accion=='INSERT') echo 'Ingresar';}?>"/></div>
 </div>
 </td>
 </tr>
 </table>
 </form>
</div> 
</div>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {maxChars:13, minChars:10, validateOn:["blur", "change"], hint:"0000000000"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false, maxChars:60, validateOn:["change"]});
//-->
</script>
