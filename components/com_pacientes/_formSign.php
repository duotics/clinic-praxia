<div class="card">
    <div class="card-header">
        <?php if ($dPac) { ?>
            <a href="<?php echo route['c'] ?>com_signos/gestSig.php?ids=<?php echo $ids ?>" class="btn btn-info btn-sm" data-type="iframe">
            <i class="fas fa-stethoscope fa-lg"></i> Registrar Signos</a>
        <?php } ?>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <input placeholder="PESO kg" name="" type="text" value="<?php echo $dPac['dPacSig']['peso'] ?? null ?>" class="form-control form-control-sm" disabled/>
                <div class="form-text">Peso en KG.</div>
            </div>
            <div class="col-sm-3">
                <input placeholder="TALLA cm" type="text" value="<?php echo $dPac['dPacSig']['talla'] ?? null ?>" class="form-control form-control-sm" disabled/>
                <div class="form-text">Talla cm.</div>
            </div>
            <div class="col-sm-3">
                <input placeholder="IMC" type="text" value="<?php echo $dPac['IMC']['val'] ?? null ?>" class="form-control form-control-sm" disabled/>
                <div class="form-text">IMC.</div>
            </div>
            <div class="col-sm-3">
                <input placeholder="Presion Arterial" type="text" value="<?php echo $dPac['dPacSig']['pa'] ?? null ?>" class="form-control form-control-sm" disabled/>
                <div class="form-text">Presion Arterial</div>
            </div>
        </div>
    </div>
    
</div>