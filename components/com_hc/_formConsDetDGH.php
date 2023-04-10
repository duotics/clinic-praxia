<?php
$qrlLCA=sprintf('SELECT * FROM db_consultas WHERE pac_cod=? ORDER BY con_num DESC LIMIT 5');
$RSlca=$db->dbh->prepare($qrlLCA);
$RSlca->bindValue(1,$idp);
//$RSlca->bindValue(2,$idc);
$RSlca->execute();
$tRSlca=$RSlca->rowCount();
$resDiag=null;
if($tRSlca>0){
    $resDiag.="<ul class='list-group list-group-flush'>";
    while($dRSlca=$RSlca->fetch()){
        $fecShow=null;
        $resDiag.="<li class='list-group-item'>";
        $resDiag.="<span>$fecShow</span>";
        $qLD=sprintf("SELECT * FROM db_consultas_diagostico 
        LEFT JOIN db_diagnosticos ON db_consultas_diagostico.id_diag=db_diagnosticos.id_diag
        WHERE db_consultas_diagostico.con_num=:con_num ORDER BY id ASC LIMIT 2");
        //echo "$qLD<br>";
        $RSld=$db->dbh->prepare($qLD);
        $RSld->bindValue(":con_num",$dRSlca['con_num'],PDO::PARAM_INT);
        $RSld->execute();
        $dRSld = $RSld->fetchAll(PDO::FETCH_ASSOC);

        //$RSld->setFetchMode(PDO::FETCH_ASSOC);
        $tRSld=$RSld->rowCount();
        
        $resDiag.="<span class='badge bg-dark'>$dRSlca[con_fec]</span>";
        
        if($tRSld){
            foreach($dRSld as $dRS){
                if($dRS['id_diag']>1){
                    $dDiag_cod=$dRS['codigo'].'-';
                    $dDiag_nom=$dRS['nombre'];
                    $dDiag_css="bg-info";
                }else{
                    $dDiag_cod=NULL;
                    $dDiag_nom=$dRS['obs'];
                    $dDiag_css="bg-light";
                }
                $resDiag.="<span class='badge bg-light $dDiag_css'>$dDiag_cod.$dDiag_nom</span>";
            }
        }
        $resDiag.="</li>";
    }
    $resDiag.='</ul>';
}else $resDiag='<div class="panel-body">Sin resultados anteriores</div>';
?>

<div class="car card-primary">
    <div class="card-header">Historial Diagnósticos anteriores</div>
    <?php echo $resDiag ?>
</div>