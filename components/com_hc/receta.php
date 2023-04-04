<?php include_once('../../init.php');
$dettrat=detRow('db_tratamientos','tid',$idt);//fnc_datatrat($idt);
$detCon=detRow('db_consultas','con_num',$dettrat['con_num']);//fnc_datatrat($idt);
$detpac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);//dataPac($dettrat['pac_cod']);
$dettrat_fecha=date_ame2euro($dettrat['fecha']);
?>
<div style="background:#FFF; padding:34px 0px 0px 72px; border:0px none #FFF; width:400px">
    <div style="padding:20px 20px 0px 20px; margin:0 0 10px 0"><br>
<div style=" padding-left:50px; margin-bottom:10px;">
Cuenca, <?php echo $dettrat_fecha?>
</div>
    <div style="padding-left:80px;">
    <table border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
    	<tbody><tr>
            <td>Receta N°. <strong><?php echo $idt ?></strong></td>
            <td>Consulta. <strong><?php echo $dettrat['con_num'] ?></strong></td>
        </tr>
        <tr><td colspan="2">Paciente. <strong><?php echo $detpac['pac_nom'].' '.$detpac['pac_ape'] ?></strong></td></tr>
        <tr>
            <td>Diagnostico</td>
            <td><strong><?php echo $dettrat['diagnostico'] ?></strong></td>
        </tr>
        </tbody>
    </table>
    </div>
    </div>
    <table style="width:515px;">
        <tr>
        	<td style="padding:0px 10px 0px 0px; height:205px;">
            <div style="font-size:16px;">
    <?php
    $qrytl=sprintf('SELECT * FROM db_tratamientos_detalle WHERE tid=%s ORDER BY id ASC',
	SSQL($idt,'int'));
	$RStl=mysqli_query(conn,$qrytl);
	$row_RStl=mysqli_fetch_assoc($RStl);
	$tr_RStl=mysqli_num_rows($RStl);
	if($tr_RStl>0){
	?>
    <ol style="margin:0px;">
    <?php $contmed=0; ?>
    	<?php do{ ?>
        <?php
        $NE=new EnLetras();
		$NumT=$NE->ValorEnLetras($row_RStl['cantidad'],'');
		$contmed++; ?>
        <li style="margin:0px;"><strong><?php echo $row_RStl['generico'] ?></strong> 
        <?php if($row_RStl['comercial']){
			echo "( ".$row_RStl['comercial']." )";
		} ?>
        <span><?php echo $row_RStl['presentacion'] ?></span> 
        <span><?php if($row_RStl['cantidad']){
			echo $row_RStl['cantidad'].' ('.$NumT.')';
		}?></span>
        </li>
		<?php }while ($row_RStl = mysqli_fetch_assoc($RStl));?>
        <?php $contmed_res=5-$contmed; ?>
    </ol>
    <br />
    <?php if ($contmed_res>0){
		for($x=0;$x<$contmed_res;$x++){ echo '<br />'; }
	}
	}else echo '<p><em>No Hay Medicamentos prescritos</em></p>'?>
    </div>
    </td>
            
        </tr>
    </table>
    
    <div style="padding:55px 20px 0px 20px; margin:0 0 10px 0"><br>
    <div style="padding-left:60px; margin-bottom:14px; padding-top:25px;">
    <table border="0" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
    	<tbody>
        <tr>
        <td style="width:220px;">Cuenca, <?php echo $dettrat_fecha?></td>
        <td>Paciente </td><td><strong><?php echo $detpac['pac_nom'].' '.$detpac['pac_ape'] ?></strong></td></tr>
        </tbody>
    </table>
    </div>
    </div>
    <table style="width:515px;">
        <tr>
        	<td style="padding:0px 0px 0px 10px; height:230px;">
            <div style="font-size:16px;">
    <?php
    $qrytld=sprintf('SELECT * FROM db_tratamientos_detalle WHERE tid=%s ORDER BY id ASC',
		SSQL($idt,'int'));
	$RStld=mysqli_query(conn,$qrytld);
	$row_RStld=mysqli_fetch_assoc($RStld);
	$tr_RStld=mysqli_num_rows($RStld);
	if(	$tr_RStld>0){
	?>
    <ol style="margin:0px;">
    	<?php do{ ?>
        <li style="margin:0px;"><strong><?php echo $row_RStld['generico'] ?></strong>
        <?php if($row_RStld['comercial']){
        echo " ( ".$row_RStld['comercial']."), ";
		} ?>
        <em><?php echo $row_RStld['descripcion'] ?></em></li>
		<?php }while ($row_RStld = mysqli_fetch_assoc($RStld));?>
    </ol>
    <?php } ?>
    </div></td>
        </tr>
    </table>
    <div style="padding-left:45px;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $dettrat['fechap'] ?>. <?php echo $dettrat['obs'] ?>
    </div>
</div>