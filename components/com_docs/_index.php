<?php

use App\Models\Documento;

$mDoc = new Documento;
$lDoc = $mDoc->getAllDet();
?>
<?php if ($lDoc) { ?>
    <table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th><abbr title="Historia Clinica">H.C.</abbr></th>
                <th>Paciente</th>
                <th>Fecha</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lDoc as $dDoc) { ?>
                <?php
                ?>
                <tr>
                    <td><?php echo $dDoc['ID']; ?></td>
                    <td><?php echo $dDoc['NOM']; ?></td>
                    <td><?php echo $dDoc['IDP']; ?></td>
                    <td><?php echo strtoupper($dDoc['PAC']) ?></td>
                    <td><?php echo $dDoc['DATE']; ?></td>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="form.php?ids=<?php echo md5($dDoc['IDP']) ?>">
                            <i class="fa fa-eye fa-lg"></i> Ver</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="alert alert-warning">
        <h4>Sin Coincidencias de Busqueda</h4>
    </div>
<?php } ?>