<?php include_once('../../init.php');

use App\Models\Paciente;

$idP = $_GET['cli_sel_find'] ?? $_POST['cli_sel_find'] ?? null;
$mPac = new Paciente($idP);
$dPac = $mPac->getDet();
//$dImg = $mPac->getlastImgPac();
//dep($dImg);
//$dCon = $db->detRow('db_consultas', null, 'pac_cod', $idP, 'con_num', 'DESC');
//$detPacFin_name = $dPac['pac_nom'] . ' ' . $dPac['pac_ape'];
//$_SESSION['sBr'] = $detPacFin_name;
//$vImg = null; //vImg("data/db/pac/", $dImg);

//$dPac_ced = $dPac['pac_ced'];
//$btnAcc .= "<a href='{$RAIZc}com_pacientes/form.php?id{$idP}' class='btn btn-primary btn-xs btn-block'><i class='fa fa-stethoscope fa-lg'></i> Consulta</a>";
//$btnAcc .= "<a href='{$RAIZc}com_consultas/form.php?idp={$idP}' class='btn btn-primary btn-xs btn-block'><i class='fa fa-user'></i> Ficha</a>";
//$detPacFin_edad = edad($dPac['pac_fec']);
?>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-4 text-center">
				<a href="<?php echo $dImg['n'] ?>" class="thumbnail fancybox" style="margin-bottom: 0">
					<img src="<?php echo $dImg['t'] ?>">
				</a>
			</div>
			<div class="col-md-2 text-center" style="padding-left: 4px; padding-right: 4px;"><?php //echo $btnAcc 
																								?></div>
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