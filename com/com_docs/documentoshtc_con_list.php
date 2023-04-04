<?php 
$qryd=sprintf('SELECT * FROM db_documentos WHERE pac_cod=%s ORDER BY id_doc DESC',
SSQL($id_pac,'int'));
$RSd=mysqli_query(conn,$qryd);
$row_RSd=mysqli_fetch_assoc($RSd);
$tr_RSd=mysqli_num_rows($RSd);
?>

<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-file-o fa-lg"></i> HISTEROSCOPIAS 
    <?php $btnDN=$RAIZc.'com_docs/documentohtc_form.php?iddf=5&idp='.$id_pac.'&idc='.$id_cons; ?>
	<a href="<?php echo $btnDN ?>" class="btn btn-default btn-xs fancybox fancybox.iframe fancyreload">NUEVO</a>    
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
    $det_id=$row_RSd['id_doc'];
	?>
	<tr>
        <td><?php echo $det_id ?></td>
		<td><?php echo $row_RSd['fecha'] ?></td>
		<td><?php echo $row_RSd['nombre'] ?></td>
		<td>
        <div class="btn-group">
        <a href="<?php echo $RAIZc ?>com_docs/print_doc.php?idd=<?php echo $det_id ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
        <i class="fa fa-eye"></i> Ver</a>
        <a href="<?php echo $RAIZc ?>com_docs/doc_print.php?id=<?php echo $det_id ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
        <i class="fa fa-print"></i> Imprimir</a>
        </div>
        <div id="docprint<?php echo $det_id ?>" style="display:none;"><?php echo ($row_RSd['contenido']) ?></div></td>
		<td><div class="btn-group">
		<a href="<?php echo $RAIZc ?>com_docs/documento_form.php?idd=<?php echo $det_id ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
        <i class="fa fa-pencil-square-o"></i> Modificar</a>
		<a href="<?php echo $RAIZc; ?>com_docs/_fncts.php?idd=<?php echo $det_id ?>&action=DELDF" class="btn btn-danger btn-xs fancybox fancybox.iframe">
        <i class="fa-solid fa-trash"></i> Eliminar</a>
		</div></td>
        </tr>
        <?php } while ($row_RSd = mysqli_fetch_assoc($RSd));?>
        </tbody>
        </table>
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSd ?></div>
</div>