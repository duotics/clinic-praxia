<?php
//if(!$_SESSION['sigm']['auto']){
    $_SESSION['sigm']['auto']='si';
    $_SESSION['sigm']['idp']=null;
//}
$q=sprintf('select * from db_busquedas_pac 
INNER JOIN db_pacientes ON db_busquedas_pac.idp=db_pacientes.pac_cod 
WHERE fec=%s ORDER BY id DESC',
SSQL($sdate,'text'));
$RS=mysqli_query(conn,$q) or die(mysqli_error(conn));
$dRS = mysqli_fetch_assoc($RS);
$tRS=mysqli_num_rows($RS);
?>
<h4>Busqueda reciente de pacientes <span class="label label-default"><?php echo $sdate ?></span></h4>
<?php if($tRS>0){ ?>
<table class="table table-bordered">
    <colgroup>
        <col width="10%">
        <col width="5%">
        <col>
        <col width="10%">
        <col width="5%">
    </colgroup>
    <thead>
        <tr class="info">
            <th></th>
            <th>ID</th>
            <th>Paciente</th>
            <th>Fecha</th>
            <th>Foto</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php do{ ?>
    <?php
        $img=null;
        $img=vImg("data/db/pac/",lastImgPac($dRS['pac_cod']));
        $iconview=null;
        if($dRS['est']==1) $iconview='<span class="label label-default"><i class="far fa-eye"></i></span>';
        else if($dRS['est']==0) $iconview='<span class="label label-default"><i class="far fa-eye-slash"></i></span>';
    ?>
        <tr>
            <td><a href="form.php?idp=<?php echo $dRS['pac_cod'] ?>&auto=no" class="btn btn-primary btn-xs">Signos</a></td>
            <td><?php echo $dRS['pac_cod'] ?></td>
            <td><?php echo $dRS['pac_nom'].' '.$dRS['pac_ape'] ?></td>
            <td><?php echo $dRS['fec'] ?></td>
            <td><a href="<?php echo $img['n'] ?>" class="fancybox"><img class="img-responsive" src="<?php echo $img['t'] ?>"></a></td>
            <td><?php echo $iconview ?></td>
        </tr>
    <?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
    </tbody>
</table>
<?php }else{ ?>
    <div class="alert alert-info"><h4>No hay consultas recientes</h4></div>
<?php } ?>
<?php echo "auto. ".$_SESSION['sigm']['auto'] ?>
<script type="text/javascript" src="js-0.2.js"></script>