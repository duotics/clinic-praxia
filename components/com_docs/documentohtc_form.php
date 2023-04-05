<?php require('../../init.php');
$_SESSION['tab']['con']='cHTC';
$idp=$_GET['idp'] ?? $_POST['idp'] ?? null;
$idc=$_GET['idc'] ?? $_POST['idc'] ?? null;
$idd=$_GET['idd'] ?? $_POST['idd'] ?? null;
$iddf='5';
$action=$_GET['action'] ?? $_POST['action'] ?? null;
$detdoc=detRow('db_documentos','id_doc',$idd);//fnc_datadoc($idd);
$detdocf=fnc_datadocf($iddf);
if($idd) {$idp=$detdoc['pac_cod']; $idc=$detdoc['con_num'];}
if($action=='DELDF') header(sprintf("Location: %s", '_fncts.php?idd='.$idd.'&action=DELDF'));
$detpac=dataPac($idp);
$detpac_nom=$detpac['pac_nom'].' '.$detpac['pac_ape'];
$detCON=detRow('db_consultas','con_num',$idc);//fnc_datacons($idc, $idp);
$detDD=detRow('db_diagnosticos','id_diag',$detCON['con_diagd']);
$detDD_nom=$detDD['nombre'];
if($detDD['codigo']){
	$detDD_nom.=" (".$detDD['codigo'].")";
}
if($detdoc){
	$action='UPD';
	$doc_date=$detdoc['fecha'];
	if ($iddf){
		$doc_nom=$detdocf['nombre'];
		$doc_con=$detdocf['formato'];
	}else{
		$doc_nom=$detdoc['nombre'];
		$doc_con=$detdoc['contenido'];
	}
	$btnform='<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> ACTUALIZAR</button>';
	$btnPrint='<a class="btn btn-info" href="'.$RAIZc.'com_docs/doc_print.php?id='.$idd.'"><i class="fa fa-print"></i></i> IMPRIMIR</a>';
}else{
	$action='INS';
	$doc_date=date('Y-m-d');
	$doc_nom=$detdocf['nombre'];
	$doc_con=$detdocf['formato'];
	$btnform='<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> GUARDAR</button>';
}

$NE=new EnLetras();
$NumD=$NE->ValorEnLetras(date('d'),'');
$NumA=$NE->ValorEnLetras(date('Y'),'');

include(root['f'].'head.php');
?>
<body class="cero">
<form action="_fncts.php" method="post" enctype="multipart/form-data" style="margin-bottom:0px;">
<fieldset class="pull-right">
    <input name="idd" type="hidden" id="idd" value="<?php echo $idd ?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
    <input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
    <input name="action" type="hidden" id="action" value="<?php echo $action ?>">
    <input name="form" type="hidden" id="form" value="fdocs">
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
      <?php echo $btnform ?>
      <?php echo $btnPrint ?>
      </div>
	</div>
</div>
</nav>
<div class="container-fluid">
<?php sLOG('g'); ?>
<div class="row">
	<div class="col-sm-8">
    	<fieldset>
			<textarea name="contenido" rows="35" class="tinymce" id="contenido" placeholder="Resultados"><?php echo $doc_con ?></textarea>
    </fieldset>
    </div>
    <div class="col-sm-4">
		<div class="well well-sm">
    <fieldset>
    
        <div class="form-group">
        	<label class="sr-only" for="fecha">Fecha</label>
        	<input name="fecha" type="date" id="fecha" value="<?php echo $doc_date; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label class="sr-only" for="exampleInputPassword2">Password</label>
            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Descripcion" value="<?php echo $doc_nom ?>">
        </div>
	</fieldset>
    </div>
	<div class="well well-sm text-center">
		<p><div class="btn-group">
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
		</div></p>
        <p><div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Paciente <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac_nom ?>');return false;">Nombre Paciente</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac['pac_ced'] ?>');return false;">Cedula</a></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo edad($detpac['pac_fec'])?>');return false;">Edad</a></li>
		</ul>
		</div></p>
        <p><div class="btn-group">
		<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Consulta <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detDD_nom ?>');return false;">Diagnostico Definitivo</a></li>
            <li class="divider"></li>
            <li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('Eduardo Baculima Bernal');return false;">Eduardo Baculima Bernal</a></li>
		</ul>
		</div></p>
    </div>
    
    </div>
</div>
</div>
</form>
</body>
</html>