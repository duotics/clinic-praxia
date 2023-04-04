<?php
$TR=totRowsTab('db_documentos_formato','1','1');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qRSd = sprintf('SELECT * FROM db_documentos_formato ORDER BY id_df DESC '.$pages->limit);
	$RSd = mysqli_query(conn,$qRSd) or die(mysqli_error());
	$dRSd = mysqli_fetch_assoc($RSd);
	$tRSd = mysqli_num_rows($RSd);
}
$btnNew='<a href="docFormatForm.php" class="btn btn-primary fancyR" data-type="iframe">'.$cfg['btn']['newI'].' '.$cfg['btn']['newT'].'</a>';
?>
<div>
<?php echo genHeader($dM,'page-header',null,$btnNew,null,'mt-3 mb-3') ?>
<?php if($tRSd>0){ ?>
<?php include(RAIZf.'paginator.php') ?>
<div class="table-responsive">   
<table class="table table-hover table-bordered table-sm" id="itm_table">
<thead><tr>
	<th>ID</th>
	<td></td>
    <th>Creado</th>
    <th width="35%">Nombre</th>
    <th>Previsualizar</th>
    <th>Cantidad</th>
    <th></th>
</tr></thead>
<tbody>
	<?php do{ ?>
	<?php 
	$id=$dRSd['id_df'];
	$ids=md5($id);
	$dA=dataAud($dRSd['idA']);
	if($dA){
		$date = date_create($dA['audd_datet']);
		$date = date_format($date, 'Y-m-d');
	}else $date=NULL;
	$btnStat=genStatus('_accDF.php',array("ids"=>$ids, "val"=>$dRSd['status'],"acc"=>md5('STf'),"url"=>$urlc));
	$btnView='<a href="docFormatPreview.php?ids='.$ids.'" class="btn btn-default btn-xs fancyI" data-type="iframe">'.$cfg['btn']['viewI'].'</a>';
	$TRd=totRowsTab('db_documentos','id_df',$id);
	?>
	<tr>
		<td><?php echo $id ?></td>
		<td><?php echo $btnStat ?></td>
		<td><?php $date ?></td>
		<td><?php echo $dRSd['nombre'] ?></td>
		<td><?php echo $btnView ?></td>
        <td><?php echo $TRd ?></td>
        <td class="text-center">
			<div class="btn-group">
          	<a href="docFormatForm.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-xs fancyR" data-type="iframe">
				<?php echo $cfg['btn']['editI'] ?>
			</a>
        	<a href="_accDF.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELf') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
        		<?php echo $cfg['btn']['delI'] ?>
			</a>
			</div>
        </td>
	    </tr>
	  <?php } while ($dRSd = mysqli_fetch_assoc($RSd)); ?>
</tbody>
</table>
</div>
<?php include(RAIZf.'paginator.php') ?>
<?php }else{ ?>
	<div class="alert alert-warning">
		<h4>No se encontraron resultados !</h4>
	</div>
<?php } ?>
</div>