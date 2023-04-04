<div class="row-fluid">
	<div class="span10 offset1">
    	<div class="row-fluid">
        	<div class="span2">Tipo Pago:</div>
            <div class="span6"><span id="spryselect1"><label>
                          <select name="lis_tip_pag" class="txt_name" id="lis_tip_pag">
                            <option value="-1" selected="selected">Seleccione Tipo Pago:</option>
                            <option value="1">Contado</option>
                          </select>
                          </label>
                        <span class="selectInvalidMsg">Tipo Seleccionado No Válido.</span>
                        <span class="selectRequiredMsg">Seleccione Tipo Pago.</span></span></div>
            <div class="span2"><label>
                        <input type="submit" name="btn_cobrar" id="btn_cobrar" value="Cobrar" class="btn" />
                          <input name="deuda" type="hidden" id="deuda" value="<?php echo $row_RS_cta_deuda['Deuda'] ?>" />
                          <input name="pac_sel_pag" type="hidden" id="pac_sel_pag" value="<?php echo $detpac['pac_cod']; ?>" />
                      </label></div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"], invalidValue:"-1"});
//-->
</script>
