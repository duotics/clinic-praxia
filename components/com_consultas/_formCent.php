<form action="_acc.php" method="post">
	<fieldset>
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>" />
		<input name="idp" type="hidden" id="idp" value="<?php echo $idsPac ?>" />
		<input name="idc" type="hidden" id="idc" value="<?php echo $idsCon ?>" />
		<input name="idr" type="hidden" id="idr" value="<?php echo $idsRes ?>" />
		<input name="cons_stat" type="hidden" id="cons_stat" value="<?php echo $dCon['status']  ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo md5('consForm') ?>" />
	</fieldset>
	<div class="container-fluid">
		<?php include('_formCentTop.php') ?>
		<?php include('_formCentHis.php') ?>
		<?php include('_formCentPac.php') ?>
		<?php //var_dump($tabS) 
		?>

		<div class="tab-content card card-body mt-2" id="v-pills-tabContent">
			<div class="tab-pane fade show <?php if (!$tabS) echo 'active' ?>" id="v-pills-hc" role="tabpanel" aria-labelledby="v-pills-hc-tab" tabindex="0">
				<?php $idRT = $objPac->detF['id']; //int value, no hashed
				include(root['c'] . 'com_hc/_hcDet.php') ?>
			</div>
			<div class="tab-pane fade <?php if ($tabS == 'cCON') echo 'active' ?>" id="v-pills-con" role="tabpanel" aria-labelledby="v-pills-con-tab" tabindex="0">
				<div id="contCons">
					<?php $vVT = TRUE; ?>
					<?php include('consultaDet.php') ?>
				</div>
			</div>
			<div class="tab-pane fade <?php if ($tabS == 'cTRA') echo 'active' ?>" id="v-pills-tra" role="tabpanel" aria-labelledby="v-pills-tra-tab" tabindex="0">
				<?php //include(root['c'].'com_tratamientos/traLisCon.php') 
				?>
			</div>
			<div class="tab-pane fade <?php if ($tabS == 'cEXA') echo 'active' ?>" id="v-pills-exa" role="tabpanel" aria-labelledby="v-pills-exa-tab" tabindex="0">
				<?php //include(root['c'].'com_examen/examLisCon.php')
				?>
			</div>
			<div class="tab-pane fade <?php if ($tabS == 'cCIR') echo 'active' ?>" id="v-pills-cir" role="tabpanel" aria-labelledby="v-pills-cir-tab" tabindex="0">
				<?php //include(root['c'].'com_cirugia/cirLisCon.php')
				?>
			</div>
			<div class="tab-pane fade <?php if ($tabS == 'cDOC') echo 'active' ?>" id="v-pills-doc" role="tabpanel" aria-labelledby="v-pills-doc-tab" tabindex="0">
				<?php //include(root['c'].'com_docs/docLisCon.php')
				?>
			</div>
			<div class="tab-pane fade <?php if ($tabS == 'cIESS') echo 'active' ?>" id="v-pills-iess" role="tabpanel" aria-labelledby="v-pills-iess-tab" tabindex="0">
				<?php //include(root['c'].'com_iess/iessRepList.php')
				?>
			</div>
			<div class="tab-pane fade <?php if ($tabS == 'cANT') echo 'active' ?>" id="v-pills-ant" role="tabpanel" aria-labelledby="v-pills-ant-tab" tabindex="0">
				<?php //include(root['c'].'com_hc/consulta_ant.php')
				?>
			</div>
		</div>

	</div>
</form>

<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<!-- END INTERFACE CONSULTA -->
<!--<script type="text/javascript" src="js/js_carga_list-cons-pac.js"></script>-->
<script type="text/javascript">
	$(document).ready(function() {
		/*
	//$('#con_diagd').chosen({});	
	var contlog = $("#log"); contlog.delay(3800).slideUp(200);
	$("#loadConData").on('click',loadCon);
*/
	});
	/*
	function loadConDiag(idc){
		//$('#consDiagDet').load(RAIZc+'com_hc/consulta_diag_det.php',{idc:idc});
		//alert('aca');
		location.reload();
	}	
	function loadCon(){	
		$("#contCons").load(RAIZc+"com_hc/consulta_det.php?idc=<?php echo $idsCon ?>&idp=<?php echo $idsPac ?>");
	}
	function setTab(val){
		$.get( "setTabJS.php", { val: val}, function( data ) {});
	}
	*/
</script>