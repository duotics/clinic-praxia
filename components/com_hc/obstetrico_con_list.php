<?php
//DET OBSTETRICA
$qryo=sprintf('SELECT * FROM db_obstetrico WHERE pac_cod=%s ORDER BY obs_id DESC',
SSQL($id_pac,'int'));
$RSo=mysqli_query(conn,$qryo);
$row_RSo=mysqli_fetch_assoc($RSo);
$tr_RSo=mysqli_num_rows($RSo);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
	<i class="fa fa-female fa-lg"></i> OBSTETRICIA
    <a href="<?php echo route['c'] ?>com_hc/obstetrico_form.php?idp=<?php echo $id_pac ?>" class="btn btn-default btn-xs fancybox.iframe fancyreload"> <i class="fa fa-plus-circle fa-lg"></i> NUEVO </a>
    
  </div>
  <div class="panel-body">
    <?php if ($tr_RSo>0){
        $classlast=TRUE;
        $classtr;
        ?>
        <div>
            <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>FUM</th>
                <th>Parto</th>
                <th>Semanas</th>
                <th>Detalle seguimiento</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php do{ ?>
            <?php $qryol=sprintf('SELECT * FROM db_obstetrico_detalle WHERE obs_id=%s ORDER BY id ASC',
			SSQL($row_RSo['obs_id'],'int'));
                $RSol=mysqli_query(conn,$qryol);
                $row_RSol=mysqli_fetch_assoc($RSol);
                $tr_RSol=mysqli_num_rows($RSol);
                if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}
            ?>
            <tr <?php echo $classtr?>>
                    <td><?php echo $row_RSo['obs_id'] ?></td>
                    <td><?php echo $row_RSo['obs_fec'] ?></td>
                    <td><?php echo $row_RSo['obs_fec_um'] ?></td>
                    <td><?php echo fnc_obst_fpp($row_RSo['obs_fec_um']) ?></td>
                    <td><?php echo fnc_obst_semges($row_RSo['obs_fec_um'],$sdate) ?></td>
                    <td>
                    <?php if ($tr_RSol>0){?>
                    <table class="table table-condensed table-bordered" style="font-size:0.8em; margin-bottom:0px;">
                    <thead><tr><th>Fecha</th>
                    <th>Detalle</th>
                    </tr></thead>
                    <tbody>
                    <?php do{?>
                    <tr><td><?php echo $row_RSol['obs_fec'] ?></td>
                    <td><?php echo $row_RSol['obs_det'] ?></td></tr>
                    <?php }while ($row_RSol = mysqli_fetch_assoc($RSol));?>
                    </tbody></table>
                    <?php }else echo '<div>No hay Visitas</div>'?>
                    </td>
                    <td><div class="btn-group">
                    <a href="<?php echo route['c'] ?>com_hc/obstetrico_form.php?ido=<?php echo $row_RSo['obs_id'] ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
                    <i class="fa fa-pencil-square-o"></i> Modificar</a>
                    <a href="<?php echo route['c']; ?>com_hc/obstetrico_form.php?ido=<?php echo $row_RSo['obs_id'] ?>&action=DELOF" rel="shadowbox:options={relOnClose:true}" class="btn btn-danger btn-xs">
                    <i class="fa-solid fa-trash"></i> Eliminar</a>
                    </div>
                    </td>
                </tr>
                <?php } while ($row_RSo = mysqli_fetch_assoc($RSo));?>
                </tbody>
                </table>
            </div>
        <?php }else echo '<div class="alert alert-warning"><h4>No Existen Seguimientos Obstétricos</h4></div>';?>
  </div>
  <div class="panel-footer">Resultados. <?php echo $tr_RSt ?></div>
</div>