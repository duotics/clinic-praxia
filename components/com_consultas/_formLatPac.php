<div class="card bg-primary text-light border-dark mb-3">
    <!--<div class="card-header bg-dark text-light pt-4 pb-2">
        Consulta
    </div>-->
    <div class="card-body">
        <div class="border-bottom border-dark mb-3 pb-3 ps-5 pe-5 mb-3 d-none d-md-block">
            <div class="ps-2 pe-2">
                <a href="<?php echo $dPacF['dPac_img']['n'] ?>" class="">
                    <img src="<?php echo $dPacF['dPac_img']['t'] ?>" class="rounded-circle img-fluid" />
                </a>
            </div>
        </div>
        <div class=" mt-3 pt-2 text-center">
            <div class="mb-2 fw-bold">
                <?php echo $dPacF['dPac_fullname'] ?>
            </div>
            <div class="mb-2">
                <?php if ($dPacF['dPac']['pac_ced']) echo "<span class='badge disabled'> DNI </span>" . $dPacF['dPac']['pac_ced']; ?>
            </div>
            <div class="mb-2">
                <a href="<?php echo route['c'] . "com_pacientes/form.php?kp=$idsPac" ?>" class="btn btn-light">
                    <?php echo $dPac['pac_cod'] ?>
                </a>
            </div>
        </div>
    </div>

</div>