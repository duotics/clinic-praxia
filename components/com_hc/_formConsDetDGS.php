<?php include_once('../../init.php');
if($idcP){
	//echo $idcP;
	$data['idc']=$idcP;
}else{
	$data=$_REQUEST;
}
$qCD=sprintf("SELECT * FROM db_consultas_diagostico WHERE con_num=?");
$RScd=$db->dbh->prepare($qCD);
$RScd->bindValue(1,$data['idc']);
$RScd->execute();
$RScd->setFetchMode(PDO::FETCH_ASSOC);
$tRScd=$RScd->rowCount();
?>

<?php if($tRScd>0){ ?>

<ul class="list-group">
    <?php while($dRScd=$RScd->fetch()){ ?>
    <?php $dDCd=$db->detRow('db_diagnosticos',null,'id_diag',$dRScd['id_diag']);
    if($dDCd['id_diag']==1){
        $nomDS=$dRScd['obs'];
        $codDS=null;
    }else{
        $nomDS=$dDCd['nombre'];
        $codDS=$dDCd['codigo'];
    }
    ?>

<li class="list-group-item">
<button class="delConDiag btn btn-danger btn-xs" type="button" data-id="<?php echo $dRScd['id_diag']?>" data-rel="delConDiag">
<i class="fa fa-trash"></i></button>
<?php echo $codDS.$nomDS ?>
</li>
<?php } ?>
</ul>
<script type="text/javascript">
$(document).ready(function(){
    $('.delConDiag').on('click', function () {
        var campo = $(this).attr("name");
        var valor = $(this).val();
        var cod = $(this).attr("data-id");
        var tbl = $(this).attr("data-rel");
        setDB('des',cod,'<?php echo $data['idc'] ?>','condiag');
        loadConDiag(<?php echo $data['idc'] ?>);
    });
});
//function delConDiag
</script>

<?php }else{ ?>
<div class="alert alert-info">Sin Diagnosticos seleccionados</div>
<?php } ?>