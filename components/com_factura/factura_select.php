<?php
include('../../init.php');
	if($_GET['LOG']==null)
		$_GET['LOG']=$_POST['LOG'];
	if ($_GET['id_pac']==null)
		$_GET['id_pac']=$_SESSION['id_pac'];		
$id_pac_sel_RS_paciente_Sel2=$_GET['id_pac'];
echo $id_pac_sel_RS_paciente_Sel2;
include(RAIZf.'head.php');

$id_pac_sel_RS_paciente_Sel = "-1";
if (isset($_GET['id_pac'])) {
  $id_pac_sel_RS_paciente_Sel = $_GET['id_pac'];
}
$query_RS_paciente_Sel = sprintf("SELECT * FROM db_pacientes WHERE db_pacientes.pac_cod=%s", SSQL($id_pac_sel_RS_paciente_Sel, "int"));
$RS_paciente_Sel = mysqli_query(conn,$query_RS_paciente_Sel) or die(mysqli_error(conn));
$row_RS_paciente_Sel = mysqli_fetch_assoc($RS_paciente_Sel);
$totalRows_RS_paciente_Sel = mysqli_num_rows($RS_paciente_Sel);

$colname_rs_cons_cli = "-1";
if (isset($_GET['pac_cod'])) {
  $colname_rs_cons_cli = $_GET['pac_cod'];
}
$query_rs_cons_cli = sprintf("SELECT * FROM tbl_cta_por_cobrar WHERE pac_cod = %s and cta_est='P' order by con_num", SSQL($id_pac_sel_RS_paciente_Sel, "int"));
$rs_cons_cli = mysqli_query(conn,$query_rs_cons_cli) or die(mysqli_error(conn));
$row_rs_cons_cli = mysqli_fetch_assoc($rs_cons_cli);
$totalRows_rs_cons_cli = mysqli_num_rows($rs_cons_cli);
?>
<?php 
//ASIGNACION A LAS LISTA DESDE LA BASE DE DATOS
$i = 1;
do 
{$lista1[$i][0]= $row_rs_cons_cli['con_num'];
 $lista1[$i][1] = $row_rs_cons_cli['cta_detalle'];
 $lista1[$i][2] = $row_rs_cons_cli['cta_valor'];
 $lista1[$i][3] = $row_rs_cons_cli['cta_fecha'];
 $lista1[$i][4] = $row_rs_cons_cli['num_cta'];
 $i = $i+1;$a=0;
}while ($row_rs_cons_cli = mysqli_fetch_assoc($rs_cons_cli));
//tamamos lista de la sesion
$j=1;
if(count($_SESSION['b'])>0)
{ foreach($_SESSION['b'] as $l)
  { $lista2[$j][0]=$l["num"];
	$lista2[$j][1]=$l["det"];
	$lista2[$j][2]=$l["val"];
	$lista2[$j][3]=$l["fec"];	
	$j++;
  }
};
//VALIDACION DE PASO A FACTURAR
$ban=1;$l=1;$k=1;
while($l < $i) 
{	$m=1;
	while($m < $j)
	{	if(($lista1[$l][0] == $lista2[$m][0]) && ($lista1[$l][1] == $lista2[$m][1]))
		{ $ban=0;
		  break;
		}
		$m++;
	}if ($ban==1)
	{ $lista3[$k][0]=$lista1[$l][0];
	  $lista3[$k][1]=$lista1[$l][1];
	  $lista3[$k][2]=$lista1[$l][2];
	  $lista3[$k][3]=$lista1[$l][3];
	  $lista3[$k][4]=$lista1[$l][4];
	  $k++;
	}else
	{$ban=1;}
	$l++;
}?>
<body>
<div id="formfac">
<div class="fac_head">
<table>
<tr>
	<td></td>
    <td><label>Consulta</label></td>
    <td><label>Detalle</label></td>
    <td><label>Valor</label></td>
    <td><label>Fecha</label></td>
</tr>
<?php  $c=1;?>
<?php if(count($lista3)>0){ ?>
<?php   foreach($lista3 as $l1){ ?>
	<tr>
    <?php $det = $l1[1];$num = $l1[0];$val = $l1[2];$fec = $l1[3];$ind = $l1[4];?>
           <td><form action="factura_det.php" method="post" id="frm1">
               <input name="" type="submit" value="Facturar"/>
               <input name="num" type="hidden" id="num" value="<?php echo $num;?>" />
               <input name="det" type="hidden" id="det" value="<?php echo $det;?>" />
               <input name="val" type="hidden" id="val" value="<?php echo $val;?>" />
               <input name="fec" type="hidden" id="fec" value="<?php echo $fec;?>" />
               <input name="ind" type="hidden" id="ind" value="<?php echo $ind;?>" />
              </form>
          </td>
          <td><?php echo $l1[0];?></td>
		  <td><?php echo $l1[1];?></td>
          <td><?php echo $l1[2];?></td>
		  <td><?php echo $l1[3];?></td>
    </tr>
<?php } ?>
<?php } ?>
</table>
</div>
</div>
</body>
</html>
<?php
mysqli_free_result($RS_paciente_Sel);
mysqli_free_result($rs_cons_cli);
?>