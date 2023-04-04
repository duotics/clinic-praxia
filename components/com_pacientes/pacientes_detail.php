<?php include('../../init.php');
$btnAcc = null;
$idcli = $_GET['cli_sel_find'] ?? $_POST['cli_sel_find'] ?? null;
$dPac = dataPac($idcli);
$dCon = detRow('db_consultas', 'pac_cod', $idcli, 'con_num', 'DESC');
$_SESSION['id_pac'] = $dPac['pac_cod']; //REVISAR
$detPacFin_name = $dPac['pac_nom'] . ' ' . $dPac['pac_ape'];
$_SESSION['sBr'] = $detPacFin_name;
$dImg = vImg("data/db/pac/", lastImgPac($dPac['pac_cod']));
$dPac_ced = $dPac['pac_ced'];
$btnAcc .= "<a href='{$RAIZc}com_pacientes/form.php?id{$idcli}' class='btn btn-primary btn-xs btn-block'><i class='fa fa-stethoscope fa-lg'></i> Consulta</a>";
$btnAcc .= "<a href='{$RAIZc}com_consultas/form.php?idp={$idcli}' class='btn btn-primary btn-xs btn-block'><i class='fa fa-user'></i> Ficha</a>";
$detPacFin_edad = edad($dPac['pac_fec']);
?>
<div class="panel panel-default" style="font-size:10px">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4 text-center">
				<a href="<?php echo $dImg['n'] ?>" class="thumbnail fancybox" style="margin-bottom: 0">
					<img src="<?php echo $dImg['t'] ?>">
				</a>
			</div>
			<div class="col-md-2 text-center" style="padding-left: 4px; padding-right: 4px;"><?php echo $btnAcc ?></div>
			<div class="col-md-6">
				<table class="table table-condensed table-bordered" style="margin:0px;">
					<tr>
						<td><?php echo $detPacFin_name ?></td>
					</tr>
					<?php if ($dPac_ced) { ?>
						<tr>
							<td><?php echo $dPac_ced ?></td>
						</tr>
					<?php } ?>
					<tr>
						<td><?php echo $dPac['pac_fec'] ?></td>
					</tr>
					<tr>
						<td><?php echo $detPacFin_edad ?></td>
					</tr>
					<tr>
						<td><span class="label label-default">Ultima Visita</span> <?php echo $dCon["con_fec"] ?? null ?> </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>