<?php

use App\Models\Dashboard;

$mDash = new Dashboard;
$lInd = $mDash->getAllIndicators();
?>
<div class="card">
    <h5 class="card-header">Indicadores</h5>
    <?php if ($lInd) { ?>
        <ul class="list-group list-group-flush">
            <?php foreach ($lInd as $dInd) { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="<?php echo $dInd['link'] ?>" class="text-dark text-decoration-none">
                        <span><?php echo $dInd['name'] ?></span>
                    </a>
                    <span class="badge bg-light"><?php echo $dInd['TR'] ?></span>

                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>