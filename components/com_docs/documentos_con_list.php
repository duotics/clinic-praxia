<?php 
$qrydf='SELECT * FROM  db_documentos_formato ORDER BY nombre ASC';
$RSdf=mysqli_query(conn,$qrydf);
$dRSdf=mysqli_fetch_assoc($RSdf);
$tr_RSdf=mysqli_num_rows($RSdf);

$qryd=sprintf('SELECT * FROM db_documentos WHERE pac_cod=%s ORDER BY id_doc DESC',
SSQL($idp,'int'));
$RSd=mysqli_query(conn,$qryd);
$dRSd=mysqli_fetch_assoc($RSd);
$tr_RSd=mysqli_num_rows($RSd);
?>

<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-file-o fa-lg"></i> DOCUMENTOS 
	
	<?php if($tr_RSdf>0){ ?>
    <div class="btn-group">
  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
    NUEVO <i class="fa fa-plus-circle fa-lg"></i> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
	<?php do{?>
    <?php $btnDN=$RAIZc.'com_docs/documentoForm.php?iddf='.$dRSdf['id_df'].'&idp='.$idp.'&idc='.$idc; ?>
    <li>
    	<a href="<?php echo $btnDN ?>" class="btn btn-default fancybox fancybox.iframe fancyreload"><?php echo $dRSdf['nombre'] ?></a>
	</li>
    <?php }while ($dRSdf = mysqli_fetch_assoc($RSdf)); ?>
	</ul>
</div>
	<?php }?>
    
  </div>
  <div class="panel-body">
    
	<?php if ($tr_RSd>0){
$classlast=TRUE;
$classtr;
?>
<div>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha</th>
		<th>Documento</th>
        <th>Documento</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
    <?php
    $idDoc=$dRSd['id_doc'];
    $idD=md5($dRSd['id_doc']);
	?>
	<tr>
        <td><?php echo $idDoc ?></td>
		<td><?php echo $dRSd['fecha'] ?></td>
		<td><?php echo $dRSd['nombre'] ?></td>
		<td>
        <div class="btn-group">
        <a href="<?php echo route['c'] ?>com_docs/print_doc.php?idd=<?php echo $idDoc ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
        <i class="fa fa-eye"></i> Ver</a>
        <!--<a href="<?php echo route['c'] ?>com_docs/doc_print.php?id=<?php echo $idDoc ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
        <i class="fa fa-print"></i> Imprimir</a>-->
        
        <a class="printerButton btn btn-default btn-xs" data-id="<?php echo $idDoc ?>" data-rel="<?php echo route['c'] ?>com_docs/docPrintJS.php">
        <i class="fa fa-print fa-lg"></i> Imprimir</a>
        
        </div>
        <div id="docprint<?php echo $idDoc ?>" style="display:none;"><?php echo ($dRSd['contenido']) ?></div></td>
		<td><div class="btn-group">
		<a href="<?php echo route['c'] ?>com_docs/documentoForm.php?idd=<?php echo $idDoc ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
    <?php echo $cfg['btn']['editI'].' '.$cfg['btn']['editT'] ?></a>
		<a href="<?php echo route['c']; ?>com_docs/documentoForm.php?idd=<?php echo $idD ?>&acc=<?php echo md5('DELd') ?>" class="btn btn-danger btn-xs fancybox fancybox.iframe fancyreload">
        <?php echo $cfg['btn']['delI'] ?></a>
		</div></td>
        </tr>
        <?php } while ($dRSd = mysqli_fetch_assoc($RSd));?>
        </tbody>
        </table>
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSd ?></div>
</div>