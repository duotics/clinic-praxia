<?php require('../../init.php');
error_reporting(0);
$id=$_GET['id'] ?? $_POST['id'] ?? null;

$qry1='SELECT db_empleados.emp_cod,db_empleados.emp_nom,db_empleados.emp_ape,usr_nombre
from db_empleados
left outer join tbl_usuario on tbl_usuario.emp_cod=db_empleados.emp_cod
where db_empleados.emp_cod='.$id;
$RSd1=mysqli_query(conn,$qry1);
$row_RSd1=mysqli_fetch_assoc($RSd1);
$qry2='SELECT * from tbl_usuario
where emp_cod='.$id;
$RSd2=mysqli_query(conn,$qry2);
$row_RSd2=mysqli_fetch_assoc($RSd2);

if($row_RSd2)
{
	$id=$row_RSd1['emp_cod'];
	$action='UPD';
	$btn_action='<button type="submit" class="btn btn-success btn-large"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}

else{
	$action='INS';
	$btn_action='<button type="submit" class="btn btn-primary btn-large"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}

$qry='SELECT db_empleados.emp_cod,db_empleados.emp_nom,db_empleados.emp_ape,usr_nombre,usr_eliminado
from db_empleados
left outer join tbl_usuario on tbl_usuario.emp_cod=db_empleados.emp_cod
where emp_status="A"';
$RSd=mysqli_query(conn,$qry);
$row_RSd=mysqli_fetch_assoc($RSd);
$tr_RSd=mysqli_num_rows($RSd);
include(root['f'].'head.php');
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
      <a class="navbar-brand" href="#">Crear Usuario</a>
    </div>
  </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid">
	<?php sLOG('g'); ?>    
	<div class="well well-sm">
	<form method="post" action="users_save.php" role="form">
    <fieldset>
        <input name="form" type="hidden" id="form" value="fmed">
        <input name="id_input" type="hidden" id="id_input" value="<?php echo $row_RSd1['emp_cod']?>">
        <input name="action" type="hidden" id="action" value="<?php echo $action?>">
    </fieldset>
    <div class="row">            
    <div class="col-sm-7"><fieldset class="form-horizontal">         
    <div class="form-group">    	
    	<div class="col-sm-12">    	
        <div class="row">
			<div class="col-sm-6">            
         <label  class="col-sm-2 control-label">Nombres</label>
            <input name="nom_emp" type="text" class="form-control" id="nom_emp"  value="<?php echo $row_RSd1['emp_nom'] ?>"  readonly>
            <label  class="col-sm-2 control-label" readonly>Apellidos</label>
            <input name="ape_emp" type="text" class="form-control" id="ape_emp"  value="<?php echo $row_RSd1['emp_ape'] ?>"  readonly>
            <label  class="col-sm-2 control-label">Nom Usuario</label>
            <input name="nom_usu" type="text" class="form-control" id="nom_usu"  value="<?php echo $row_RSd1['usr_nombre'] ?>" required>
            </div>
            <div class="col-sm-6">
            <label  class="col-sm-2 control-label">Password</label>
            <input name="pass_usu" type="password" class="form-control" id="pass_usu"  value="" required>
            <table>
            <tr>
            <th>
            	<span id="mensaje">
            </th>
            </tr>
            </table>
            <label class="col-sm-2 control-label">Confirmar Password</label>
            <input name="con_pass" type="password" class="form-control" id="con_pass"  value="" required onkeyup="verificar(this.value);">
          
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
			<th>Nombre</th>
			<th>Apellido</th>                       			
			<th>Nombre Usuario</th>
      <th>Estado</th>
                      
		</tr>
	</thead>
	<tbody>
	<?php do{?>
		<tr>                
			 <td><?php echo $row_RSd['emp_nom'] ?></td>
       <td><?php echo $row_RSd['emp_ape'] ?></td>
			 <td><?php echo $row_RSd['usr_nombre']?></td>
       <td>
          <?php if($row_RSd['usr_eliminado']=='N')
          {
             $aux='Activo'; 
          }
          if($row_RSd['usr_eliminado']=='S')
          {
            $aux='Eliminado';
          }
          echo $aux;
          ?>
       </td>                                       		
			<td>
				<a href="<?php echo $_SESSION['urlc'] ?>?id=<?php echo $row_RSd['emp_cod'] ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i> Modificar</a>
				<a href="users_save.php?id=<?php echo $row_RSd['emp_cod'] ?>&action=DEL" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
			</td>
		</tr>
	<?php } while ($row_RSd = mysqli_fetch_assoc($RSd));?>
	</tbody>
	</table>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Usuarios Generados</h4></div>'; }?>
</div>
</body>
</html>

<script type="text/javascript">
function verificar(v){
var p1 = document.getElementById('pass_usu');
if( p1.value != v){
document.getElementById('mensaje').innerHTML = "la contrasena no coincide";
}
  else
  {
    document.getElementById('mensaje').innerHTML = "Las contrasena son iguales";
  }
}
</script>