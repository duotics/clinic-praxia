<?php
$qryE=sprintf('SELECT * FROM db_empleados ORDER BY emp_cod DESC');
$RSe=mysqli_query(conn,$qryE);
$dRSe = mysqli_fetch_assoc($RSe);
$tRSe = mysqli_num_rows($RSe);
?>
<?php if($tRSe>0){ ?>
<table class="table table-condensed table-bordered" id="mytable" >
	<thead>
    <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Cedula</th>
        <th>Telefono</th>
        <th>Celular</th>
        <th>Email</th>
        <th>Usuario</th>
        <th>Estado</th>
        <th></th>                
    </tr>
    </thead>
    <tbody>
<?php do { ?> 
<?php
$btnStat=fncStat('acc.php',array("id"=>$dRSe['emp_cod'], "val"=>$dRSe['emp_status'],"acc"=>md5('STAT'),"url"=>$_SESSION['urlc']));
$dTip=detRow('db_types','typ_cod',$dRSe['typ_cod']);
$dU=detRow('tbl_usuario','emp_cod',$dRSe['emp_cod']);
if($dU) $btnUser='<a class="btn btn-info btn-xs"><i class="fa fa-user fa-lg"></i></a>';
else $btnUser='<span class="label label-default"><i class="fa fa-close"></i></span>'; ?>
    <tr>
      <td><?php echo $dRSe['emp_cod'] ?></td>
      <td><?php echo $dTip['typ_val'] ?></td>
      <td><?php echo $dRSe['emp_nom'] ?></td>
      <td><?php echo $dRSe['emp_ape'] ?></td>
      <td><?php echo $dRSe['emp_ced'] ?></td>
      <td><?php echo $dRSe['emp_tel'] ?></td>
      <td><?php echo $dRSe['emp_cel'] ?></td>
      <td><?php echo $dRSe['emp_mail'] ?></td>
      <td class="text-center"><?php echo $btnUser ?></td>
      <td class="text-center"><?php echo $btnStat ?></td>
      <td class="text-center">
      <div class="btn-group">
        <a href="form.php?id=<?php echo $dRSe['emp_cod'] ?>" class="btn btn-primary btn-xs">
        <i class="fa fa-edit fa-lg"></i> Editar</a>
        <a href="acc.php?acc=<?php echo md5('DELE') ?>&id=<?php echo $dRSe['emp_cod']?>" class="btn btn-danger btn-xs">
        <i class="fa fa-trash fa-lg"></i> Eliminar</a>
      </div>  	         
      </td>                
    </tr>  
<?php } while ($dRSe = mysqli_fetch_assoc($RSe)); ?>
</tbody>
</table>
<?php }else{ ?>
<div class="alert alert-info">
<h4>No Existen empleados registrados</h4>
</div>
<?php } ?>