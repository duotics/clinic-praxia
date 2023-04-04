<?php 
$qry=sprintf('SELECT * FROM db_examenes WHERE con_num=%s OR pac_cod=%s ORDER BY id_exa DESC',
SSQL($id_cons,'int'),
SSQL($id_pac,'int'));
$RSe=mysqli_query(conn,$qry);
$row_RSe=mysqli_fetch_assoc($RSe);
$tr_RSe=mysqli_num_rows($RSe);
?>

<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-list-alt fa-lg"></i> EXAMENES
    <a href="<?php echo $RAIZc ?>com_hc/examen_form.php?idp=<?php echo $id_pac ?>&idc=<?php echo $id_cons ?>&action=NEW" class="btn btn-default btn-xs fancybox.iframe fancyreload"> NUEVO <i class="fa fa-plus-circle fa-lg"></i> </a>
  </div>
  <div class="panel-body">
  
  <?php if ($tr_RSe>0){
$classlast=TRUE;
$classtr;
?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Fecha</th>
        <th>Descripcion</th>
        <th>Resultado</th>
        <th>Imagenes</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
	if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $row_RSe['id_exa'] ?></td>
			<td><?php echo $row_RSe['fecha'] ?></td>
            <td><?php echo $row_RSe['descripcion'] ?></td>
            <td><?php echo $row_RSe['resultado'] ?></td>
            <td><?php //echo exam_numimg($row_RSe['id']) ?></td>
            <td>
            <div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_hc/examen_form.php?ide=<?php echo $row_RSe['id_exa'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload"><i class="fa fa-pencil-square-o"></i> Modificar</a>
            <a href="<?php echo $RAIZc; ?>com_hc/examen_form.php?ide=<?php echo $row_RSe['id_exa'] ?>&action=DELEF" class="btn btn-default btn-danger btn-xs fancybox.iframe fancyclose"><i class="fa-solid fa-trash"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($row_RSe = mysqli_fetch_assoc($RSe));?>
        </tbody>
        </table>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSe ?></div>
</div>