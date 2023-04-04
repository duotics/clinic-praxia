<?php 
$dRSg=detRow('db_pacientes_gin','pac_cod',$idp);
if(!$dRSg){
	echo 'No existe. ';
	$array = array('pac_cod'=>$idp);
	$data=insRow('db_pacientes_gin',$array);
	$id_gin=$data['id'];
}else $id_gin=$dRSg['gin_id'];
?>
<fieldset>
<legend>Ginecologia</legend>
<div class="well well-sm" style="background:#FFF">
<div class="row">
	<div class="col-sm-2">
    <a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Primera Menstruación">Menarca</a>
    <input name="gin_men" type="text" class="form-control" id="gin_men" value="<?php echo $dRSg['gin_men'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
    </div>
    <div class="col-sm-2">
    <a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Numero de Gestaciones">Gestaciones</a>
    <input name="gin_ges" type="text" class="form-control" id="gin_ges" value="<?php echo $dRSg['gin_ges'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
	</div>
	<div class="col-sm-2">
    <a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Partos normales">Vaginal</a>
	<input name="gin_pnor" type="text" class="form-control" id="gin_pnor" value="<?php echo $dRSg['gin_pnor'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
    </div>
    <div class="col-sm-2">
    <a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Cesareas Realizadas">Cesareas</a>
  	<input name="gin_pces" type="text" class="form-control" id="gin_pces" value="<?php echo $dRSg['gin_pces'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
    </div>
    <div class="col-sm-1">
    <a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Hijos vivos">Vivos</a>
  	<input name="gin_hviv" type="text" class="form-control" id="gin_hviv" value="<?php echo $dRSg['gin_hviv'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
    </div>
    <div class="col-sm-1">
    <a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Hijos muertos">Muertos</a>
  	<input name="gin_hmue" type="text" class="form-control" id="gin_hmue" value="<?php echo $dRSg['gin_hmue'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
    </div>
    <div class="col-sm-2">
    <a class="btn btn-default btn-block btn-sm tooltips" data-placement="top" data-original-title="Cantidad de Abortos">Abortos</a>
  	<input name="gin_abo" type="text" class="form-control" id="gin_abo" value="<?php echo $dRSg['gin_abo'] ?>" placeholder="0" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
    </div>
</div>
</div>
<div class="row">
	<div class="col-md-5">
    	<div class="well well-sm" style="background:#FFF;">
			<fieldset class="form-horizontal">
            			
            <div class="form-group">
            	<label for="gin_fun" class="col-md-4 control-label">FUM</label>
                <div class="col-md-8">
  					<input name="gin_fun" type="date" class="form-control" id="gin_fun" value="<?php echo $dRSg['gin_fun'] ?>" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')" onChange="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
               	</div>
			</div>
            <div class="form-group">
            	<label for="gin_cicm" class="col-md-4 control-label">CM</label>
                <div class="col-md-8">
  					<input name="gin_cicm" type="text" class="form-control" id="gin_cicm" value="<?php echo $dRSg['gin_cicm'] ?>" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"/>
               	</div>
			</div>
            </fieldset>
		</div>
    </div>    	
	<div class="col-md-7">
    	<div class="well well-sm" style="background:#FFF">
        <label>Observaciones</label>
            <textarea name="gin_obs" rows="3" class="form-control" id="gin_obs" onKeyUp="setDB(this.name,this.value,<?php echo $id_gin ?>,'gin')"><?php echo $dRSg['gin_obs'] ?></textarea>
        </div>
    </div>
</div>
</fieldset>