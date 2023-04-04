<?php
if (isset($dCon['con_fec'])) $dCon_fec = date("d M Y", strtotime($dCon['con_fec'] ?? null));
else $dCon_fec = date("d M Y");
?>
<nav class="navbar navbar-inverse" style="margin:0px">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-cons-dat">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Fecha</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-cons-dat">
			<ul class="nav navbar-nav">
				<li style="font-size:120%"><a><abbr title="Actualizada. <?php echo $dCon['con_upd']; ?>">
							<?php echo $dCon_fec ?></abbr></a></li>
				<li><a><abbr title="Actualizada. ">
							Origen Paciente</abbr></a></li>
			</ul>

			<div class="navbar-form navbar-left">

				<div class="form-group">
					<?php
					$paramsTC[] = array(
						array("cond" => "AND", "field" => "typ_ref", "comp" => "=", "val" => 'TIPCON'),
						array("cond" => "AND", "field" => "typ_stat", "comp" => '=', "val" => 1)
					);
					$RStc = detRowGSelNP('db_types', 'typ_cod', 'typ_val', $paramsTC, TRUE, 'typ_val', 'ASC');
					genSelect('con_typ', $RStc, $dCon['con_typ'] ?? null, 'form-control input-sm', ' onChange="setDB(this.name,this.value,' . $idc . ',' . "'con'" . ')"', 'con_typ', NULL, TRUE, NULL, '- Seleccione -'); 			 ?>
				</div>
			</div>

			<ul class="nav navbar-nav">
				<li><a><abbr title="Porque motivo viene ">
							Tipo Visita </abbr></a></li>
			</ul>
			<div class="navbar-form">
				<div class="form-group">
					<?php
					$paramsN[] = array(
						array("cond" => "AND", "field" => "typ_ref", "comp" => "=", "val" => 'TIPVIS'),
						array("cond" => "AND", "field" => "typ_stat", "comp" => '=', "val" => 1)
					);
					$RS = detRowGSelNP('db_types', 'typ_cod', 'typ_val', $paramsN, TRUE, 'typ_val', 'ASC');
					genSelect('con_typvis', $RS, $dCon['con_typvis'] ?? null, 'form-control input-sm', ' onChange="setDB(this.name,this.value,' . $idc . ',' . "'con'" . ')"', 'con_typvis', NULL, TRUE, NULL, '- Seleccione -'); ?>
				</div>
				<div class="form-group">
					<input name="con_val" type="text" value="<?php echo $dCon['con_val'] ?? null ?>" class="form-control input-sm" placeholder="Valor" onkeyup="setDB(this.name,this.value,'<?php echo $idc ?>','con')" />
				</div>
				<div class="form-group">
					<?php genSelect('tip_pag', detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'TIPPAG'), $dCon['tip_pag'] ?? null, 'form-control input-sm', ' onChange="setDB(this.name,this.value,' . $idc . ',' . "'con'" . ')"', NULL, NULL, TRUE, NULL, '- Tipo de Pago -'); ?>
				</div>

			</div>
		</div>
	</div>
</nav>