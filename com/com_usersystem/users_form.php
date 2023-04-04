<?php require('../../init.php');
error_reporting(0);
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$detMed=detRow('db_empleados','emp_cod',$id);

if($detMed)
{
	$id=$detMed['emp_cod'];
	$action='UPD';
	$btn_action='<button type="submit" class="btn btn-success btn-large"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}

else{
	$action='INS';
	$btn_action='<button type="submit" class="btn btn-primary btn-large"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}

$qry='SELECT * FROM db_empleados where emp_status="A" ORDER BY emp_cod DESC';
$RSd=mysqli_query(conn,$qry);
$row_RSd=mysqli_fetch_assoc($RSd);
$tr_RSd=mysqli_num_rows($RSd);
include(RAIZf.'head.php');
?>
<body class="cero">
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
      <a class="navbar-brand" href="#">Crear Usuariosdadsasd</a>
    </div>
  </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid">
	<?php sLOG('g'); ?>
	<div class="well well-sm">
	<form method="post" action="empleados_save.php" role="form">
    <fieldset>
        <input name="form" type="hidden" id="form" value="fmed">
        <input name="id_input" type="hidden" id="id_input" value="<?php echo $detMed['emp_cod']?>">
        <input name="action" type="hidden" id="action" value="<?php echo $action?>">
    </fieldset>
    <div class="row">
    
    
    
    <div class="col-sm-7"><fieldset class="form-horizontal">         
    <div class="form-group">    	
    	<div class="col-sm-12">    	
        <div class="row">
			<div class="col-sm-6">
            <label for="ced" class="col-sm-2 control-label">Cedula</label>
            <input name="ced_emp" type="text" class="form-control" id="ced_emp"  value="<?php echo $detMed['emp_ced'] ?>" required>
         <label for="generico" class="col-sm-2 control-label">Nombres</label>
            <input name="nom_emp" type="text" class="form-control" id="nom_emp"  value="<?php echo $detMed['emp_nom'] ?>" required>
            <label for="generico" class="col-sm-2 control-label">Apellidos</label>
            <input name="ape_emp" type="text" class="form-control" id="ape_emp"  value="<?php echo $detMed['emp_ape'] ?>" required>
            <label for="generico" class="col-sm-2 control-label">Direccion</label>
            <input name="dir_emp" type="text" class="form-control" id="dir_emp"  value="<?php echo $detMed['emp_dir'] ?>" required>
            </div>
            <div class="col-sm-6">
            <label for="generico" class="col-sm-2 control-label">Telefono</label>
            <input name="tel_emp" type="text" class="form-control" id="tel_emp"  value="<?php echo $detMed['emp_tel'] ?>" required>
         <label for="generico" class="col-sm-2 control-label">Celular</label>
            <input name="cel_emp" type="text" class="form-control" id="cel_emp"  value="<?php echo $detMed['emp_cel'] ?>" required>
            <label for="generico" class="col-sm-2 control-label">E-mail</label>
            <input name="mail_emp" type="text" class="form-control" id="mail_emp"  value="<?php echo $detMed['emp_mail'] ?>" required>
            </div>			
		</div>
        
		</div>
	</div>                        
    </fieldset></div>
                       
    <div class="col-sm-5"><fieldset class="form-horizontal">
    <div class="form-group">
    	<label for="" class="col-sm-2 control-label"></label>
    	<div class="col-sm-10">
    	<?php echo $btn_action ?>    	
    	</div>
	</div>
    </fieldset></div>
    </div>
            
	</form>
	</div>
<?php if ($tr_RSd>0){ ?>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>Cedula</th>
			<th>Nombre</th>
			<th>Apellido</th>                       			
			<th>Dierccion</th>
            <th>Telefono</th>
            <th>Celular</th>
            <th>E-mail</th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
		<tr>
			<td><?php echo $row_RSd['emp_ced'] ?></td>
			<td><?php echo $row_RSd['emp_nom'] ?></td>
            <td><?php echo $row_RSd['emp_ape'] ?></td>
			<td><?php echo $row_RSd['emp_dir']?></td>
            <td><?php echo $row_RSd['emp_tel'] ?></td>
            <td><?php echo $row_RSd['emp_cel'] ?></td>
            <td><?php echo $row_RSd['emp_mail'] ?></td>                   			
			<td>
				<a href="<?php echo $_SESSION['urlc'] ?>?id=<?php echo $row_RSd['emp_cod'] ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i> Modificar</a>
				<a href="empleados_save.php?id=<?php echo $row_RSd['emp_cod'] ?>&action=DEL" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
			</td>
		</tr>
	<?php } while ($row_RSd = mysqli_fetch_assoc($RSd));?>
	</tbody>
	</table>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Recursos Generados</h4></div>'; }?>
</div>
</body>
</html>