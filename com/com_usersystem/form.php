<?php include('../../init.php');
$dM = $Auth->vLogin('USERS');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$det = detRow('tbl_usuario', 'usr_id', $id);
if ($det) {
     $acc = md5('UPD');
     $btnAcc = '<button type="submit" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
     $detE = detRow('db_empleados', 'emp_cod', $det['emp_cod']);
     $idE = $detE['emp_cod'];
     $detT = detRow('db_types', 'typ_cod', $detE['typ_cod']);
} else {
     $acc = md5('INS');
     $btnAcc = '<button type="submit" class="btn btn-primary" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
}
$btnNew = '<a class="btn btn-default" href="form.php"><i class="fa fa-plus fa-lg"></i> Nuevo</a>';
include(RAIZf . "head.php");
include(RAIZm . 'mod_menu/menuMain.php');
sLOG('g') ?>
<ul class="breadcrumb">
     <li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li>
     <li><a href="<?php echo $RAIZc ?>com_usersystem">Usuarios</a></li>
     <li class="active">Formulario</li>
</ul>
<div class="container">
     <form action="actions.php" method="post" role="form">
          <input type="hidden" name="id" value="<?php echo $id ?>">
          <input type="hidden" name="form" value="formUsr">
          <input type="hidden" name="acc" value="<?php echo $acc ?>">
          <?php echo genHeader(NULL, 'page-header', $det['usr_nombre'], $btnAcc . $btnNew, $id, null, "h2") ?>
          <div class="row">
               <div class="col-sm-6">
                    <div class="panel panel-primary">
                         <div class="panel-heading"><i class="fa fa-sign-in fa-lg"></i> Datos de Usuario</div>
                         <div class="panel-body">
                              <fieldset class="form-horizontal">
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Nombre Usuario</label>
                                        <div class="col-sm-9">
                                             <input name="inpUserNom" class="form-control" type="text" placeholder="nombre de usuario" value="<?php echo $det['usr_nombre'] ?>" autocomplete="off">
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                             <input name="formPassNew1" class="form-control" type="password" placeholder="Contraseña de usuario" autocomplete="off">
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Confirmar Password</label>
                                        <div class="col-sm-9">
                                             <input name="formPassNew2" class="form-control" type="password" placeholder="Contraseña de usuario" autocomplete="off">
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Tema</label>
                                        <div class="col-sm-9">
                                             <input list="themes" name="inpUserTheme" value="<?php echo $det['usr_theme'] ?>" class="form-control">
                                             <datalist id="themes">
                                                  <option value="yeti">bootstrap-yeti.min.css</option>
                                                  <option value="darkly">bootstrap-darkly.min.css</option>
                                                  <option value="cerulean">bootstrap-cerulean.min.css</option>
                                                  <option value="flatly">bootstrap-flatly.min.css</option>
                                                  <option value="cosmo">bootstrap-cosmo.min.css</option>
                                                  <option value="united">bootstrap-united.min.css</option>
                                                  <option value="superHero">bootstrap-superhero.min.css</option>
                                                  <option value="readable">bootstrap-readable.min.css</option>
                                                  <option value="lumen">bootstrap-lumen.min.css</option>
                                                  <option value="journal">bootstrap-journal.min.css</option>
                                                  <option value="simplex">bootstrap-simplex.min.css</option>
                                             </datalist>
                                        </div>
                                   </div>
                              </fieldset>
                         </div>
                    </div>
               </div>
               <div class="col-sm-6">
                    <div class="panel panel-info">
                         <div class="panel-heading"><i class="fa fa-info-circle fa-lg"></i> Información del Empleado</div>
                         <div class="panel-body">
                              <fieldset class="form-horizontal">
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Empleado</label>
                                        <div class="col-sm-9">
                                             <?php $qryLENU = sprintf(
                                                  'SELECT emp_cod as sID,CONCAT_WS(" ",emp_nom,emp_ape) as sVAL 
					 FROM db_empleados 
					 WHERE emp_cod NOT IN (SELECT emp_cod FROM tbl_usuario)  OR emp_cod=%s',
                                                  SSQL($idE, 'int')
                                             );
                                             $RSlenu = mysqli_query(conn, $qryLENU) or die(mysqli_error(conn));
                                             genSelect('inpEmpCod', $RSlenu, $det['emp_cod'], 'form-control', ''); ?>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Tipo</label>
                                        <div class="col-sm-9">
                                             <input type="text" value="<?php echo $detT['typ_val'] ?>" class="form-control" placeholder="" readonly>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Cedula</label>
                                        <div class="col-sm-9">
                                             <input type="text" value="<?php echo $detE['emp_ced'] ?>" class="form-control" placeholder="Documento Identidad" readonly>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Nombres</label>
                                        <div class="col-sm-9">
                                             <div class="row">
                                                  <div class="col-sm-6">
                                                       <input type="text" class="form-control" placeholder="Nombres" value="<?php echo $detE['emp_nom'] ?>" readonly>
                                                  </div>
                                                  <div class="col-sm-6">
                                                       <input type="text" class="form-control" placeholder="Apellidos" value="<?php echo $detE['emp_ape'] ?>" readonly>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Telefonos</label>
                                        <div class="col-sm-9">
                                             <div class="row">
                                                  <div class="col-sm-6">
                                                       <input type="text" class="form-control" placeholder="Fijo" value="<?php echo $detE['emp_tel'] ?>" readonly>
                                                  </div>
                                                  <div class="col-sm-6">
                                                       <input type="text" class="form-control" placeholder="Celular" value="<?php echo $detE['emp_cel'] ?>" readonly>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                             <input type="email" value="<?php echo $detE['emp_mail'] ?>" class="form-control" placeholder="Email" readonly>
                                        </div>
                                   </div>

                                   <div class="text-center">
                                        <a class="btn btn-info" href="<?php echo $RAIZc ?>com_empleados/form.php?id=<?php echo $idE ?>">
                                             <i class="fa fa-edit fa-lg"></i> Editar informacion Empleado</a>
                                   </div>

                              </fieldset>
                         </div>
                    </div>
               </div>
          </div>
     </form>
</div>
<?php include(RAIZf . 'footer.php') ?>