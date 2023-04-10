<?php
/*$dPacV=null;
if($dPacF['dPac_edad']['yF']){
    $dPacV['yF']="<span class='badge bg-light'><span class='text-muted'>Edad</span> <?php echo $dPacF[dPac_edad][yF]</span>";
    //<span><?php echo $dPacF['dPac_fullname'] ?></span>
}*/
$objPac->PacienteInterfaz_ConsultaNav();
//var_dump($dPacF);
?>

<div class="card bg-success bg-opacity-10">
    <div class="card-body d-lg-none">
        <?php echo $objPac -> objNavLG; ?>
    </div>
    <div class="card-body d-none d-lg-block">
        <?php echo $objPac -> objNavSM; ?>
    </div>
</div>
<!--
<div class="card  ">
    <div class="card-body p-2">
        view on large
        
        <span title="<?php echo $dPacF['fecha'] ?? null ?>">Signos</span>
        <span title="Peso" class="btn btn-light btn-sm"><?php echo $dPacSig['peso'] ?? null ?> Kg.</span> 
        <span title="Estatura"  class="btn btn-light btn-sm"><?php echo $dPacSig['talla'] ?? null ?> cm.</span> 
        <span title="IMC" class="btn btn-light btn-sm"><?php echo $IMC['val'] ?></span><?php echo $IMC['inf'] ?>
        <span title="Presion Arterial"  class="btn btn-light btn-sm"><?php echo $dPacSig['pa'] ?? null ?> p.a.</span> 
        <a href="<?php echo $RAIZc ?>com_signos/gestSig.php?ids=<?php echo md5($idsPac) ?>" class="btn btn-primary btn-sm fancyR" data-type="iframe">
            <i class="far fa-check-square fa-lg fa-fw"></i> Registrar
        </a>

    </div>
</div>
-->