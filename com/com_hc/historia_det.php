<?php
$dHC=detRow('db_paciente_hc','pac_cod',$idp);
if(!$dHC){
	$array = array('pac_cod'=>$idp);
	$data=insRow('db_paciente_hc',$array);
	$id_hc=$data['id'];
}else $id_hc=$dHC['hc_id'];
?>
<fieldset>
<div class="well well-sm">
<div class="row">
	<div class="col-md-3">
    <div class="form-group">
    <label for="hc_antp">Antecedentes Personales</label>
    <textarea name="hc_antp" class="form-control setDB" id="hc_antp" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_antp'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_antf">Antecedentes Familiares</label>
    <textarea name="hc_antf" class="form-control setDB" id="hc_antf" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_antf'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_antf">Antecedentes Clínicos</label>
    <textarea name="hc_cli" class="form-control setDB" id="hc_cli" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_cli'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_antf">Antecedentes Quirurgicos</label>
    <textarea name="hc_qui" class="form-control setDB" id="hc_qui" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_qui'] ?></textarea>
  </div>
    </div>
	<div class="col-md-3">
    <div class="form-group">
    <label for="hc_ale">Alergias</label>
    <textarea name="hc_ale" class="form-control setDB" id="hc_ale" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_ale'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_ale">Toma Medicamentos</label>
    <textarea name="hc_tmed" class="form-control setDB" id="hc_tmed" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_tmed'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_hab">Habitos</label>
    <textarea name="hc_hab" class="form-control setDB" id="hc_hab" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_hab'] ?></textarea>
  </div>
    </div>
    <div class="col-md-3">
    <div class="form-group">
    <label for="hc_hab">Deportes</label>
    <textarea name="hc_depo" class="form-control setDB" id="hc_depo" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_depo'] ?></textarea>
  </div>
    </div>
</div>
</div>

<div class="well well-sm" style="background:#FFF">
<div class="row">
	<div class="col-md-4">
    <fieldset class="form-horizontal">
    <div class="form-group">
		<label class="col-xs-4 control-label"><strong>FUMA</strong></label>
        <div class="col-xs-8">
        <?php generarselect('hc_fuma',detRowGSel('db_types','typ_cod','typ_val','typ_ref','SINO'),$dHC['hc_fuma'],'setDB form-control input-sm', "data-id='".md5($id_hc)."' data-rel='hc'"); ?>
        </div>
	</div>
    <div class="form-group">
    <label for="hc_fumat" class="col-xs-4 control-label">Tiempo Fuma<br>(Años)</label>
    <div class="col-xs-8">
    <textarea name="hc_fumat" onChange="calcIT()" class="form-control setDB" id="hc_fumat" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_fumat'] ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="hc_fumac" class="col-xs-4 control-label">Cantidad Fuma (cigarrillos al día)</label>
    <div class="col-xs-8">
    <textarea name="hc_fumac" onChange="calcIT()" class="form-control setDB" id="hc_fumac" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_fumac'] ?></textarea>
    </div>
  </div>
	<div class="form-group">
		<label for="" class="control-label col-xs-3" data-toggle="tooltip" data-placement="left" title="El indice tabaquico sirve para calcular la posibilidad que tiene un fumador de sufrir de EPOC (Enfermedad Pulmonar Obstructiva Crónica) y que la mayoría de las veces es causada por el hecho de consumir tabaco o también de estar expuesto a humo, polvos, etc.">
			Indice Tabaquico
		</label>
		<div class="col-sm-9">
			<div id="resIT"></div>
		</div>
	</div>
    
    </fieldset>
    </div>
    <div class="col-md-3">
    <fieldset class="form-horizontal">
    <div class="form-group">
		<label class="col-xs-4 control-label"><strong>ALCOHOL</strong></label>
        <div class="col-xs-8">
        <?php generarselect('hc_alco',detRowGSel('db_types','typ_cod','typ_val','typ_ref','SINO'),$dHC['hc_alco'],'setDB form-control input-sm', "data-id='".md5($id_hc)."' data-rel='hc'"); ?>
        </div>
	</div>
    <div class="form-group">
    <label for="hc_alcot" class="col-xs-4 control-label">Tiempo Alcohol</label>
    <div class="col-xs-8">
    <textarea name="hc_alcot" class="form-control setDB" id="hc_alcot" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_alcot'] ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="hc_alcoc" class="col-xs-4 control-label">Cantidad Alcohol</label>
    <div class="col-xs-8">
    <textarea name="hc_alcoc" class="form-control setDB" id="hc_alcoc" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_alcoc'] ?></textarea>
    </div>
  </div>
    
    </fieldset>
    </div>
    <div class="col-md-3">
    <fieldset class="form-horizontal">
    <div class="form-group">
		<label class="col-xs-4 control-label"><strong>DROGAS</strong></label>
        <div class="col-xs-8">
        <?php generarselect('hc_drog',detRowGSel('db_types','typ_cod','typ_val','typ_ref','SINO'),$dHC['hc_drog'],'setDB form-control input-sm', "data-id='".md5($id_hc)."' data-rel='hc'"); ?>
        </div>
	</div>
    <div class="form-group">
    <label for="hc_drogt" class="col-xs-4 control-label">Tiempo Drogas</label>
    <div class="col-xs-8">
    <textarea name="hc_drogt" class="form-control setDB" id="hc_drogt" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_drogt'] ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="hc_drogc" class="col-xs-4 control-label">Cantidad Drogas</label>
    <div class="col-xs-8">
    <textarea name="hc_drogc" class="form-control setDB" id="hc_drogc" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_drogc'] ?></textarea>
    </div>
  </div>
    
    </fieldset>
    </div>
	<div class="col-md-2">
    <div class="form-group">
    <label for="hc_obs">Observaciones</label>
    <textarea name="hc_obs" class="form-control setDB" id="hc_obs" rows="4" data-id="<?php echo md5($id_hc) ?>" data-rel="hc"><?php echo $dHC['hc_obs'] ?></textarea>
  </div>
    </div>
</div>
</div>
<!--
<div class="well well-sm">
<div class="row">
	<div class="col-md-3">
    <div class="form-group">
    <label for="hc_fum">F.U.M.</label>
    <input type="date" name="hc_fum" id="hc_fum" class="form-control" onKeyUp="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')" onChange="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')" value="<?php echo $dHC['hc_fum'] ?>"/>
  </div>
    </div>
</div>
</div>
-->
</fieldset>
<script>
calcIT();
function calcIT(){
	var pFT = $('#hc_fumat').val();
	var pFC = $('#hc_fumac').val();
	var IT=(pFT/20)*pFC;
	$('#resIT').removeClass();
	if(IT<10){
		$('#resIT').addClass('label label-default');
		$('#resIT').html(IT+' = Riesgo <strong>Nulo</strong> ');
	}else if((IT>=10)&&(IT<=20)){
		$('#resIT').addClass('alert alert-info');
		$('#resIT').html('<h4>'+IT+' = Riesgo <strong>MODERADO</strong></h4>* Probabilidad de desarrollar E.P.O.C.');
	}else if((IT>=21)&&(IT<=40)){
		$('#resIT').addClass('alert alert-warning');
		$('#resIT').html('<h4>'+IT+' = Riesgo <strong>INTENSO</strong></h4>* Probabilidad de desarrollar E.P.O.C.<br>* Probabilidad de desarrollar cáncer de pulmón');
	}else if(IT>=41){
		$('#resIT').addClass('alert alert-danger');
		$('#resIT').html('<h4>'+IT+' = Riesgo <strong>ALTO</strong></h4>* Probabilidad de desarrollar E.P.O.C.<br>* Probabilidad de desarrollar cáncer de pulmón');
	}
}
</script>