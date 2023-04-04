<div class="form-horizontal">
    <div class="form-group">
        <label for="generico" class="col-sm-3 control-label">Listado Medicamentos</label>
        <div class="col-sm-9">
            <?php
            $lMedList = $mMed->getAllSelect();
            echo $db->genSelectA($lMedList, 'listMed', NULL, 'form-control input-sm', "data-val='{$ids}'", 'listMed', true, null, '- Seleccione Medicamento -');
            ?>
        </div>
    </div>
</div>
<?php
$lMedGroup = $mMed->gelAllMedGroupParent($id);
?>
<?php if ($lMedGroup > 0) { ?>
    <table class="table table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>ID Medicamento</th>
                <th>Medicamento</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lMedGroup as $dMRG) { ?>
                <?php
                $idsRowMG = md5($dMRG["IDG"]);
                $accMG = md5("DELmg");
                $btnDelMG = "<a href='_acc.php?idr=$idsRowMG&acc=$accMG&url=$urlc' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i> Eliminar</a>";
                ?>
                <tr>
                    <td><?php echo $btnDelMG ?></td>
                    <td><?php echo $dMRG["IDG"] ?></td>
                    <td><?php echo $dMRG["IDM"] ?></td>
                    <td><?php echo "$dMRG[GEN] ( $dMRG[COM] ) $dMRG[PRE] $dMRG[CAN] <br><small>$dMRG[DES]</small>" ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="alert alert-info">
        <h4>No existen medicamentos agrupados relacionados</h4>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#listMed').select2({
            width: "100%"
        });
        $('#listMed').on('select2:select', function(e) {
            $(this).val('').trigger('change');
            var data = e.params.data;
            var idp = $(this).data('val'); // Get the selected value from the input list
            var dataAjax = {
                idp: idp,
                idm: data.id,
                acc: "insMedGroup"
            }; // Create an object with the data to be sent to the server
            var url = '_accMed.php';
            //console.log(idp);

            $.ajax({
                url: url,
                method: 'GET',
                data: dataAjax,
                success: function(response) {
                    console.log('Data saved successfully: ' + response);
                    location.reload();
                    //table.ajax.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error saving data: ' + textStatus + ' - ' + errorThrown);
                }
            });

        });
    });

    function doGetMedicamento(evt, params) {
        var id = params.selected;
        $.getJSON("json.medicamento.php?param=" + id, function(data) {
            $.each(data, function(key, val) {
                console.log(val);
                //$("#idref").val(val.ID);

                //$("#dtAG").trigger("click");
            });
        });
    }
</script>