<?php
$sql=sprintf("SELECT id_diag as sID, CONCAT_WS(' - ',codigo,nombre) as sVAL FROM db_diagnosticos WHERE estado=1 ORDER BY id_diag ASC");
$RSd = $db->dbh->prepare($sql);
$RSd->setFetchMode(PDO::FETCH_ASSOC);
$RSd->execute();
$tRSd=$RSd->rowCount();
//echo $tRSd;




?>

<div class="row">
	<div class="col-sm-8">
		<div class="card">
			<div class="card-header">
				<i class="fa fa-user-md fa-lg"></i> Diagnosticos
				<a href="<?php echo route['c'] ?>com_comun/gest_diag.php" class="btn btn-info btn-sm"><i class="fa fa-plus-square-o"></i> Gestionar Diagnosticos</a>
			</div>
			<div class="card-body">
				
				<div class="row">
					<div class="col-sm-6">
						<div class="mb-3">
						<?php echo $db->genSelectA($RSd,"diagSel[]",NULL,'form-control', '', 'chosDiag',true,null);?>
						</div>
						<div class="mb-3">
							<input type="text" class="form-control" name="diagD" id="diagD" placeholder="Otros Diagnósticos">
						</div>
						<div class="mb-3">
							<button type="button" class="setConDiagOtro btn btn-info btn-xs">AGREGAR</button>
						</div>
					</div>
					<div class="col-sm-6">
						<div id="consDiagDet">
            			<?php 
			   			$idcP=$idc;
			   			include('_formConsDetDGS.php');
						?>
            			</div>


						
					</div><!--col-5-->
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<?php include('_formConsDetDGH.php') ?>
	</div>
</div>



		

		
		
<?php $RSd -> closeCursor(); ?>



<script type="text/javascript">
$(document).ready(function(){
	function do_something(evt, params){
		var  target = $(event.target),
		priorDataSet = target.data("chosen-values"),
		currentDataSet = target.val();
		//Diff and compare the delta here.    
		target.data("chosen-values", currentDataSet);
	};
	$('#chosDiag').select2({
		placeholder_text_multiple: "Seleccione los Diagnosticos Posibles"
	});
	$('#chosDiag').on('change', function(evt, params) {
		var valSel=params['selected'];
		var valDes=params['deselected'];
		var accC;
		if(valSel){
			accC='sel';
			valC=valSel;
		}
		if(valDes){
			accC='des';
			valC=valDes;
		}
		//alert(valC);
		if(valC>1){
			setDB(accC,valC,'<?php echo $idc ?>','condiag');
			loadConDiag(<?php echo $idc ?>);
		}else{ 
			//alert ('OTRO');
			//$("#diagD").focus();
			$("#diagD").focus();
		}
	});
	$('.setConDiagOtro').on('click', function () {
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var cod = $(this).attr("data-id");
		var tbl = $(this).attr("data-rel");
		var desDiag = $('#diagD');
		//alert(desDiag.val());
		setDB('otro',desDiag.val(),'<?php echo $idc ?>','condiag');
		desDiag.val('');
		loadConDiag(<?php echo $idc ?>);
	});
});
</script>