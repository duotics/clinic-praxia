<?php require('../../init.php');

$idp=$_GET['idp'] ?? $_POST['idp'] ?? null;
$idc=$_GET['idc'] ?? $_POST['idc'] ?? null;
$idd=$_GET['idd'] ?? $_POST['idd'] ?? null;
$iddf=vParam('iddf',$_GET['iddf'],$_POST['iddf']);
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;

if($acc==md5(DELd)) header(sprintf("Location: %s", '_fncts.php?idd='.$idd.'&acc='.md5(DELd)));

$qrydf='SELECT * FROM  db_documentos_formato ORDER BY nombre ASC';
$RSdf=mysqli_query(conn,$qrydf);
$row_RSdf=mysqli_fetch_assoc($RSdf);
$tr_RSdf=mysqli_num_rows($RSdf);


$detdoc=detRow('db_documentos','id_doc',$idd);//fnc_datadoc($idd);
$detdocf=fnc_datadocf($iddf);
if($idd) {$idp=$detdoc['pac_cod']; $idc=$detdoc['con_num'];}
$detpac=dataPac($idp);
$detpac_nom=$detpac['pac_nom'].' '.$detpac['pac_ape'];
$detCON=fnc_datacons($idc, $idp);
if($detdoc){
	$acc=md5(UPDd);
	$doc_date=$detdoc['fecha'];
	if ($iddf){
		$doc_nom=$detdocf['nombre'];
		$doc_con=$detdocf['formato'];
	}else{
		$doc_nom=$detdoc['nombre'];
		$doc_con=$detdoc['contenido'];
	}
	$btnAcc='<button type="submit" class="btn btn-success" name="btnA"><i class="fa fa-floppy-o" aria-hidden="true"></i> ACTUALIZAR</button>';
	$btnAccP='<button type="submit" class="btn btn-primary" name="btnP"><i class="fa fa-floppy-o" aria-hidden="true"></i> ACTUALIZAR E IMPRIMIR</button>';
}else{
	$acc=md5(INSd);
	$doc_date=$sdate;
	$doc_nom=$detdocf['nombre'];
	$doc_con=$detdocf['formato'];
	$dat['fec']=$sdate;
	$dat['nom']=$detpac_nom;
	$dat['doc']=$detpac['pac_ced'];
	$dat['edad']=edad($detpac['pac_fec'],' Años');
	$dat[idc]=$idc;
	$doc_conG=genDoc($doc_nom,$dat);
	$doc_con=$doc_conG['format'];
	$btnAcc='<button type="submit" class="btn btn-info" name="btnA"><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR</button>';
	$btnAccP='<button type="submit" class="btn btn-primary" name="btnP"><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR E IMPRIMIR</button>';
}

$NE=new EnLetras();
$NumD=$NE->ValorEnLetras(date('d'),'');
$NumA=$NE->ValorEnLetras(date('Y'),'');
$css[body]='cero';
include(root['f'].'head.php'); ?>
<form action="_fncts.php" method="post" enctype="multipart/form-data" style="margin-bottom:0px;">
<fieldset class="pull-right">
	<input name="idd" type="hidden" id="idd" value="<?php echo $idd ?>">
	<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
	<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
	<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
	<input name="fecha" type="hidden" id="fecha" value="<?php echo $doc_date ?>">
	<input name="form" type="hidden" id="form" value="<?php echo md5(fDocs) ?>">
	<input name="url" type="hidden" value="<?php echo $urlc ?>">
</fieldset>

<nav class="navbar navbar-default" role="navigation">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-file-o"></i> DOCUMENTO</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li><a><span class="label label-info"><?php echo $idd ?></span></a></li>
        <li><a><?php echo $detpac_nom ?></a></li>
        <li><a>Consulta: <span class="label label-default"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $detdoc['fecha'] ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <?php echo $btnAcc ?>
      <?php echo $btnAccP ?>
      </div>
	</div>
</div>
</nav>
<?php sLOG(g); ?>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-8">
    	<fieldset>
    		
    	<?php $doc_con2 = str_replace('{RAIZ}',$RAIZ,$doc_con) ?>
			<textarea name="contenido" style="min-height: 575px" class="tinymce" id="contenido" placeholder="Resultados"><?php echo $doc_con2 ?></textarea>
    </fieldset>
    </div>
    <div class="col-sm-4">
    
    
    
		<div class="well well-sm">
    <fieldset class="form-horizontal">
        <div class="form-group">
        	<label for="fecha" class="control-label col-sm-3">Fecha</label>
        	<div class="col-sm-9"><input value="<?php echo $doc_date; ?>" class="form-control" disabled></div>
        </div>
        <div class="form-group">
            <label for="nombre" class="control-label col-sm-3">Nombre</label>
            <div class="col-sm-9"><input name="nombre" type="text" class="form-control" id="nombre" placeholder="Descripcion" value="<?php echo $doc_nom ?>"></div>
        </div>
	</fieldset>
    </div>
    <div class="panel panel-primary">
    	<div class="panel-heading"><h4 class="panel-title">Dias de Reposo</h4></div>
    	<div class="panel-body">
    		<fieldset class="form-horizontal">
    		<div class="form-group">
    			<label for="" class="control-label col-sm-2">Inicio del Reposo</label>
    			<div class="col-sm-10">
    				<input type="date" class="form-control" id="dpFec" value="<?php echo $sdate ?>">
    			</div>
    		</div>
			<div class="form-group">
    			<label for="" class="control-label col-sm-2">Dias de Reposo</label>
    			<div class="col-sm-10">
    				<input type="number" class="form-control input-lg" id="dpDia" value="1">
    			</div>
    		</div>
			<div class="form-group cero">
				<div class="col-sm-10 col-sm-offset-2"><a href="javascript:;" onClick="genDias()" class="btn btn-info btn-sm btn-block">Generar Dias Reposo</a></div>
			</div>
			
			</fieldset>
    	</div>
    </div>
	<div class="well well-sm text-center">
		<div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Fechas / Horas <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo strftime("%A %d de %B del %Y") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> <?php echo strftime("%A %d de %B del %Y") ?></a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo strftime("a los ".$NumD." dias del mes de %B de ".$NumA."") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> Fecha en letras</a></li>
            <li class="divider"></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo date("h:i:s") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> Hora /12</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo date("H:i:s") ?>');return false;">
            	<i class="icon-calendar icon-white"></i> Hora /24</a></li>
		</ul>
		</div>
        <div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Paciente <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac_nom ?>');return false;">Nombre Paciente</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac['pac_ced'] ?>');return false;">Cedula</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo edad($detpac['pac_fec'])?>');return false;">Edad</a></li>
		</ul>
		</div>
        <div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Consulta <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<!--<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detDD_nom ?>');return false;">Diagnostico Definitivo</a></li>
            <li class="divider"></li>-->
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('Ricardo Ordoñez V.');return false;">Ricardo Ordoñez V.</a></li>
		</ul>
		</div>
    </div>
    <div class="well well-sm text-center">
    	<div class="btn-group">
  <a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Cambiar a <span class="caret"></span></a>
  <ul class="dropdown-menu">
		<?php do{?>
        <li><a href="<?php echo route['c'] ?>com_docs/documentoForm.php?idd=<?php echo $idd ?>&iddf=<?php echo $row_RSdf['id_df'] ?>&idp=<?php echo $idp ?>&idc=<?php echo $idc?>&action=NEW"><i class="icon-file"></i> <small>Cambiar a</small> <?php echo $row_RSdf['nombre'] ?></a></li>
	<?php }while ($row_RSdf = mysqli_fetch_assoc($RSdf)); ?>  

  </ul>
</div>
    </div>
    </div>
</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$.ajaxSetup({
   async: false
 });
});
function genDias(){
	
	var dpFec=$('#dpFec').val();
	var dpDia=$('#dpDia').val();
	
	$.getJSON( "json.getDate.php?rFec="+dpFec+"&rDia="+dpDia, function( data ) {
		$.each( data, function( key, val ) {
			tinymce.activeEditor.insertContent(val.val);
  		});
	});
}
</script>
<?php include(root['f'].'footerC.php');