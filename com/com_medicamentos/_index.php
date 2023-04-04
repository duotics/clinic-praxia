<?php
$TRt['med'] = totRowsTab('db_medicamentos');
$TRt['ind'] = totRowsTab('db_indicaciones');
$TRt['lab'] = totRowsTab('db_laboratorio');
?>
<div class="container">
    <div class="row">

        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Laboratorios <span class="badge badge-info"><?php echo $TRt['lab'] ?></span></h3>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $RAIZc ?>com_laboratorios/laboratorio.php" class="btn btn-primary btn-lg btn-block">
                        Gestionar Laboratorios
                    </a>
                    <a href="<?php echo $RAIZc ?>com_laboratorios/laboratorioForm.php" class="btn btn-default btn-block">
                        <?php echo $cfg['btn']['newI'] ?>
                        <?php echo $cfg['btn']['newT'] ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Medicamentos <span class="badge badge-info"><?php echo $TRt['med'] ?></span></h3>
                </div>
                <div class="panel-body">
                    <a href="medicamentos.php" class="btn btn-primary btn-lg btn-block">
                        Gestionar Medicamentos
                    </a>
                    <a href="medicamentosForm.php" class="btn btn-default btn-block">
                        <?php echo $cfg['btn']['newI'] ?>
                        <?php echo $cfg['btn']['newT'] ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Indicaciones <span class="badge badge-info"><?php echo $TRt['ind'] ?></span></h3>
                </div>
                <div class="panel-body">
                    <a href="indicaciones.php" class="btn btn-primary btn-lg btn-block">
                        Gestionar Indicaciones
                    </a>
                    <a href="indicacionesForm.php" class="btn btn-default btn-block">
                        <?php echo $cfg['btn']['newI'] ?>
                        <?php echo $cfg['btn']['newT'] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>