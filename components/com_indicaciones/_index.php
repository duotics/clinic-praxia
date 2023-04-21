<?php

use App\Models\Medicamento;
use App\Models\Indicacion;
use App\Models\Laboratorio;

$mMed = new Medicamento();
$mInd = new Indicacion();
$mLab = new Laboratorio();

$TRt['med'] = $mMed->getTR();
$TRt['lab'] = $mLab->getTR();
$TRt['ind'] = $mInd->getTR();
?>
<div class="mt-2">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <h3 class="card-header bg-primary text-white">
                    Laboratorios <span class="badge bg-light float-end"><?php echo $TRt['lab'] ?></span>
                </h3>
                <div class="card-body">
                    <div class="btn-group">
                        <a href="<?php echo route['c'] ?>com_laboratorios/laboratorio.php" class="btn btn-primary">
                            Gestionar
                        </a>
                        <a href="<?php echo route['c'] ?>com_laboratorios/laboratorioForm.php" class="btn btn-light">
                            <?php echo $cfg['b']['new'] ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <h3 class="card-header bg-primary text-white">
                    Medicamentos <span class="badge bg-light float-end"><?php echo $TRt['med'] ?></span>
                </h3>
                <div class="card-body">
                    <div class="btn-group">
                        <a href="medicamentos.php" class="btn btn-primary">
                            Gestionar
                        </a>
                        <a href="medicamentosForm.php" class="btn btn-light">
                            <?php echo $cfg['b']['new'] ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <h3 class="card-header bg-primary text-white">
                    Indicaciones <span class="badge bg-light float-end"><?php echo $TRt['ind'] ?></span>
                </h3>
                <div class="card-body">
                    <div class="btn-group">
                        <a href="indicaciones.php" class="btn btn-primary">
                            Gestionar
                        </a>
                        <a href="indicacionesForm.php" class="btn btn-light">
                            <?php echo $cfg['b']['new'] ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>