<?php 
	include('../../init.php');
	$iduser = $_SESSION['dU']['ID'];
	include(RAIZf.'head.php');
?>

<!doctype html>
<html>
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
      <a class="navbar-brand" href="#">Permisos Usuarios</a>
    </div>
  </div><!-- /.container-fluid -->
</nav>

	<?php
	$sql = sprintf("SELECT * FROM tbl_usuario WHERE usr_eliminado = 'N' ORDER BY usr_id DESC");
	$query = mysqli_query(conn,$sql) or die(mysqli_error(conn));
	$row = mysqli_fetch_assoc($query);
	$tot_rows = mysqli_num_rows($query); 
	?>
    
	<div class="container">
		
        <div class="row-fluid">
        	<div class="span8">
                
			</div>           
		</div>
		<div class="portlet-body">			
            <?php if($tot_rows > 0)	{ ?>
            <div class="row-fluid">
			<table class="table table-bordered table-condensed table-striped" id="tab_usr">
				<thead>
					<tr>
						<th width="125px"></th>
						<th>Id</th>
						<th>Nombre</th>
                        <th>Apellido</th>
						<th>Nombre de usuario</th>                        
					</tr>
				</thead>
				<tbody>
					<?php do {
						$detempleado=detRow('db_empleados',$row['emp_cod'],$emp_cod);
					//$empleado = fnc_datEmp($row['emp_id']);
					//$detpersona=detRow('db_empleados',$row['emp_cod'],$emp_cod);
					//$persona = fnc_datPer($empleado['per_id']);					
					//$edad = fnc_calEdad($persona['per_fec_nac']);
					?>
					<tr>
						<td>
                            <div class="btn-group">
                        		<a href="menus_permiso.php?user_id=<?php echo $row['usr_id']; ?>" class="btn btn-primary btn-xs"><i class="icon-edit"></i> Editar</a>                        		
                    		</div>
						</td>
						<td><?php echo $row['usr_id']; ?></td>
						<td><?php echo $detempleado['emp_nombre']; ?></td>
                        <td><?php echo $detempleado['emp_ape']; ?></td>
						<td><?php echo $row['usr_nombre']; ?></td>                         
					</tr>
					<?php } while ($row = mysqli_fetch_assoc($query)); ?>
				</tbody>
			</table>
            </div>        			
			<?php mysqli_free_result($query);
			}else{ echo '<div class="alert alert-error"><h4>No existen usuarios registrados.</h4></div>'; } ?>
		</div>     	     
	</div>
</body>
<footer>	
</footer>
</html>
