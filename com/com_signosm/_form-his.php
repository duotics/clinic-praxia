<?php
$qH = sprintf(
    'SELECT * FROM db_signos WHERE pac_cod=%s ORDER BY id DESC',
    SSQL($idp, 'int')
);
$RSh = mysqli_query(conn, $qH) or die(mysqli_error(conn));
$dRSh = mysqli_fetch_assoc($RSh);
$tRSh = mysqli_num_rows($RSh);
?>
<?php if ($tRSh > 0) { ?>
    <div>
        <table class="table table-striped table-bordered" style="font-size:110%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Peso</th>
                    <th>Talla</th>
                    <th>IMC</th>
                    <th>PA</th>
                    <th>Temp</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php do { ?>
                    <?php
                    $pesoKG = $dRSh['peso'] . ' Kg.';
                    $pesoLB = round($dRSh['peso'] * 2.20462262, 2);
                    $pesoLB .= ' Lb.';
                    $tallaCM;
                    $tallaPL;
                    if ($dRSh['talla']) {
                        $tallaCM = $dRSh['talla'] . ' Cm';
                        $tallaPL = round($dRSh['talla'] / 2.54, 2);
                        $tallaPL .= ' "';
                        $tallaM = (int)$tallaCM / 100;
                    }

                    $IMC = $dRSh['imc'];
                    $IMC = calcIMC($IMC, $pesoKG, $tallaCM ?? 0);
                    ?>
                    <tr>
                        <td><?php echo $dRSh['id'] ?></td>
                        <td><?php echo $dRSh['fecha'] ?></td>
                        <td><span title="<?php echo $pesoLB ?>" class="tooltips" data-original-title="Fecha Registro"><?php echo $pesoKG ?></span>
                        </td>
                        <td><?php echo $tallaCM ?? 0 ?></td>
                        <td><span title="<?php echo $IMC['val'] ?>" class="tooltips" data-original-title="Fecha Registro"><?php echo $IMC['inf'] ?></span>
                        </td>
                        <td><?php echo $dRSh['paS'] . '/' . $dRSh['paD'] ?></td>
                        <td><?php echo $dRSh['temp'] ?></td>
                        <td>
                            <a href="form.php?ids=<?php echo $dRSh['id'] ?>" class="btn btn-info btn-xs">
                                <i class="fas fa-edit"></i> Edit</a>
                            <a href="_acc.php?ids=<?php echo $id ?>&ids=<?php echo $dRSh['id'] ?>&acc=<?php echo md5('DELs') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } while ($dRSh = mysqli_fetch_assoc($RSh)); ?>
            </tbody>
        </table>
    </div>
<?php } else {
    echo '<div class="alert alert-warning"><h4>No Existen Registros</h4></div>';
} ?>
<?php mysqli_free_result($RSh);
