<?php
$id=null;
$ids=null;
if(isset($_REQUEST['ids'])) $ids=$_REQUEST['ids'];
$dF=detRow('db_documentos_formato','md5(id_df)',$ids);
if($dF){
	$id=$dF['id_df'];
	$acc=md5('UPDf');
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc">'.$cfg['btn']['updI'].' '.$cfg['btn']['updT'].'</button>';
}else{
	$acc=md5('INSf');
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc">'.$cfg['btn']['insI'].' '.$cfg['btn']['insT'].'</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default">'.$cfg['btn']['newI'].' '.$cfg['btn']['newT'].'</a>';
?>
<form action="_accDF.php" method="post" enctype="multipart/form-data">

<?php //$cont='<li><a href="#">'.$id.'</a></li>'.
//'<li><a href="#">'.$dF['nombre'].'</a></li>';
echo genHeader($dM,'navbar',null);
$dH=array('id'=>$id,'mod_nom'=>$dF['nombre'],'icon'=>null);
echo genHeader($dH,'page-header',null,$btnAcc.$btnNew,null,null,'h2'); ?>

	<fieldset>
		<input name="ids" type="hidden" id="ids" value="<?php echo $ids ?>">
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="form" type="hidden" id="form" value="<?php echo md5('fFormat') ?>">
		<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
	</fieldset>
	
	<div class="row">
		<div class="col-sm-5">
			<div class="well">
				<fieldset class="form-horizontal">
				<div class="form-group row">
					<label class="col-form-label col-sm-4" for="iNom">NOMBRE FORMATO</label>
					<div class="col-sm-8">
						<input name="iNom" id="iNom" type="text" class="form-control" placeholder="Nombre del Formato" value="<?php echo $dF['nombre'] ?>" autofocus>
					</div>
				</div>
					<div class="form-group row">
					<label for="" class="col-form-label col-sm-4">ACTIVO</label>
					<div class="col-sm-8">
						<?php $params=array("1"=>"Activo", "0"=>"Inactivo");
						echo genFormsInpRadio($params,$dF['status'],'inline',1,'iStat'); ?>
					</div>
				</div>
				</fieldset>
			</div>
			<div class="">
				<?php
				$qCF=sprintf('SELECT * FROM db_types WHERE typ_ref=%s',
								SSQL('docFormat','text'));
				$RScf=mysqli_query(conn,$qCF);
				$dRScf=mysqli_fetch_assoc($RScf);
				$tRScf=mysqli_num_rows($RScf);
				?>
				<?php if($tRScf>0){ ?>
				<table class="table table-condensed table-striped table-sm">
					<tr>
						<th></th>
						<th>Campos Disponibles</th>
						<th>Codigo</th>
						<th>ejemplo</th>
						<th>Observaciones</th>
					</tr>
					<?php do{ ?>
					<tr>
						<th><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $dRScf['typ_val'] ?>');return false;" class="label label-default">
							<i class="fa fa-chevron-right"></i>
							</a>
						</th>
						<td><?php echo $dRScf['typ_nom'] ?></td>
						<td><?php echo $dRScf['typ_val'] ?></td>
						<td><?php echo $dRScf['typ_aux'] ?></td>
						<td><?php echo $dRScf['mod_cod'] ?></td>
					</tr>
					<?php }while($dRScf=mysqli_fetch_assoc($RScf)) ?>
				</table>
				<?php } ?>
			</div>
		</div>
		<div class="col-sm-6">
			<div>
				<textarea name="iFor" class="form-control tinymce" style="min-height: 600px"><?php echo $dF['formato'] ?></textarea>
			</div>
		</div>
	</div>
</form>