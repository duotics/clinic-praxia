<?php include('../../init.php');
$cont=1;
include(RAIZf.'head.php');
?>
<body>
<div id="formfac">
<div class="fac_head">
            <table>
                	<tr>
        			<td><label>Nº FACTURA:</label>
            		<p><?php $res = fnc_datafacnum();
					if ($res['num']== ''){echo "1";$f_num = 1;}
					else {echo $res['num']+1;$f_num =$res['num']+1;}?>
            		</p>
            		</td>      
       		<td><label>FECHA:</label>
           	<p><?php echo date("Y-m-d ");?></p></td>	     
       		<td><label>PACIENTE:</label>
           	<p><?php $res=dataPac($_SESSION['id_pac']); 
			echo $res['pac_nom']." ".$res['pac_ape']; ?></p></td>           
       		<td><label>EMPLEADO:</label>
	   		<p><?php //$res=dataEmp($_SESSION['dU']['NAME']); 			echo $res['emp_nom']." ".$res['emp_ape']; ?></p></td>              
		</tr>
        </table>       
</div>
<div class="fac_det"><label>DETALLE DE FACTURA</label></div>
<div class="fac_detail">
        	<table>
            <?php if(count($_SESSION['b'])>0){ ?>
                <tr>
                <td></td>
            	<td><label>Consulta</label></td>
                <td><label>Detalle</label></td>
            	<td><label>Valor</label></td>
            	<td><label>Fecha</label></td>
            	</tr>
            <?php  foreach($_SESSION['b'] as $v){ ?>
            <?php $num1 = $v["num"];$det1 = $v["det"];$val1 = $v["val"];$fec1 = $v["fec"];$ind1 = $v["ind"];?>
                <tr>
                	<td>
                    	<form action="_fncts.php" method="post" id="frm_2">
                         <input name="" type="submit" value="Cancelar" onClick="fac_reg()"/>
                         <input name="num1" type="hidden" id="num1" value="<?php echo $num1;?>" />
                         <input name="det1" type="hidden" id="det1" value="<?php echo $det1;?>" />
                         <input name="val1" type="hidden" id="val1" value="<?php echo $val1;?>" />
                         <input name="fec1" type="hidden" id="fec1" value="<?php echo $fec1;?>" />
                         <input name="ind1" type="hidden" id="ind1" value="<?php echo $ind1;?>" />
                         <input name="mod" type="hidden" id="mod" value="cancelar" />
                         
                        </form>
                    </td>
                <td><?php echo $v["num"];?></td>
                   <td><?php echo $v["det"];?></td>
                   <td>
                       <form id="frm3" action="_fncts.php" method="post">
                         <span id="sprytextfield<?php echo $cont; ?>"><?php $cont++; ?>
                         <input type="text" value="<?php echo $v["val_fac"];?>" onChange="factura_sum.php" id="val2" name="val2"/>
                         <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                         <input name="ind_sum" id="ind_sum" type="hidden" value="<?php echo $v["ind"];?>" />   
                         <input name="mod" type="hidden" id="mod" value="sumar" />            
                       </form>
                   </td>
                    <?php $suma = $suma + $v["val_fac"];?>
                   <td><?php echo $v["fec"];?></td>
                </tr>
            <?php } ?>
         </table>
         </div>
<div class="fac_top">
<form action="factura_save.php" method="post">
<table>
<tr>
<td>         
<label>TIPO PAGO:</label> 
     <span id="spryselect3">
               <p><select name="fac_tip_pag" id="fac_tip_pag">
                  <option value="-1">Seleccione Tipo Pago</option>
                  <option value="1">Contado</option>
                  <option value="2">Credito</option>
                  <option value="3">Cheque</option>
                  <option value="4">Poliza</option>
                </select></p>
              <span class="selectInvalidMsg">Seleccione un elemento válido.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></td> 
<td><label>TOTAL:</label>                                  
    <p><input type="text" id="total" value="<?php  echo $suma;?>"/><?php $_SESSION['total']=$suma;?></p></td>             
<td>
<input type="submit" name="confirm" id="confirm" value="Facturar"/><input name="fac_num" type="hidden" id="fac_num" value="<?php echo $f_num; ?>" />
         <input name="fac_fec" type="hidden" id="fac_fec" value="<?php echo date("Y-m-d ");?>" />
         <input name="fac_pac" type="hidden" id="fac_pac" value="<?php echo $_SESSION['id_pac']; ?>" />
         <input type="hidden" name="fac_emp" id="fac_emp" value="<?php echo $res['emp_cod']; ?>" />
</td>
</tr>
</table>      
</form>
</div>
<?php }else{echo 'Agregar Detalle';}?>
</div>
<div align="center"><a href="factura_select.php" rel="shadowbox; width=400; height=400;options={relOnClose:true}"><img src="../../images/struct/icons/Add-a_32x32.png"/></a> </div>
</div>
<?php echo $_GET['LOG']; ?>
<script type="text/javascript">
<?php for ($i=1;$i<$cont; $i++){ ?>
var sprytextfield<?php echo $i; ?> = new Spry.Widget.ValidationTextField("sprytextfield<?php echo $i; ?>", "currency");
<?php } ?>
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {invalidValue:"-1", validateOn:["blur", "change"]});
</script>
</body>
</html>