<?php require_once('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$detPac=dPac($id);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
if($detPac['pac_fec']) $detPac_fec=edad($detPac['pac_fec']).'Años';

?>
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
      <a class="navbar-brand" href="#">EXAMENES</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?php echo $detPac_nom ?></a></li>
        <li><a><?php echo $detPac_fec ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <a href="<?php echo route['c'] ?>com_examen/examenForm.php?idp=<?php echo $id ?>" class="btn btn-info fancyreload fancybox.iframe"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO EXAMEN</a>
      </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li><a href="<?php echo route['c'].'com_index/'?>">Inicio</a></li>
  <li><a href="<?php echo route['c'].'com_examen/'?>">Examenes</a></li>
  <li class="active">Paciente</li>
</ol>
<?php if($detPac){
$qry=sprintf('SELECT * FROM db_examenes WHERE pac_cod=%s ORDER BY id_exa DESC',
SSQL($id,'int'));
$RSh=mysqli_query(conn,$qry);
$row_RSh=mysqli_fetch_assoc($RSh);
$tr_RSh=mysqli_num_rows($RSh);
?>
<div>

<?php if ($tr_RSh>0){ ?>
	<div>
	  <table class="table table-striped table-bordered">
        <thead>
        <tr>
        	<th>ID</th>
            <th><abbr title="Fecha Registro">Fecha R.</abbr></th>
            <th><abbr title="Fecha Examen">Fecha E.</abbr></th>
            <th>Descripcion</th>
            <th>Resultado</th>
            <th></th>
		</tr>
        </thead>
        <tbody>
        <?php do{ ?>
        <tr>
        	<td><?php echo $row_RSh['id_exa'] ?></td>
			<td><?php echo $row_RSh['fecha'] ?></td>
   			<td><?php echo $row_RSh['fechae'] ?></td>
			<td><?php echo $row_RSh['descripcion'] ?></td>
   			<td><?php echo $row_RSh['resultado'] ?></td>
            <td>
            <a class="btn btn-info btn-xs fancyreload fancybox.iframe" href="<?php echo route['c'] ?>com_examen/examenForm.php?ide=<?php echo $row_RSh['id_exa'];?>">
        	<i class="fa fa-edit fa-lg"></i> Editar</a>
            <a href="_fncts.php?ide=<?php echo $row_RSh['id_exa'] ?>&acc=<?php echo md5('DELE') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
            <i class="fa-solid fa-trash"></i> Eliminar</a></td>
        </tr>
        <?php } while ($row_RSh = mysqli_fetch_assoc($RSh));
		$rows = mysqli_num_rows($RSh);
		if($rows > 0) {
			mysqli_data_seek($RSh, 0);
			$row_RSh = mysqli_fetch_assoc($RSh);
		}?>
        </tbody>
        </table>
    </div>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No Existen Registros</h4></div>';
}?>
</div>
<?php mysqli_free_result($RSh);
}else{ ?>
<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>