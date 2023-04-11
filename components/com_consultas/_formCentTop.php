<?php
if (isset($dCon['con_fec'])) $dCon_fec = date("d M Y", strtotime($dCon['con_fec']));
else $dCon_fec = date("d M Y");
//dep($dM);
$dataHead = array("icon" => $dM['icon'] ?? null, "nom" => $dM['nom'] ?? null, "des" => $idc ?? null);

$contHead = " <span class='badge bg-secondary'>Visita " . $objCon->btnHis['TRs'] . "</span> 
<span class='badge bg-info'>{$dCon_fec}</span>
<a class='btn btn-primary' data-bs-toggle='offcanvas' href='#offcanvasExample' role='button' aria-controls='offcanvasExample'>
<i class='fas fa-history fa-lg'></i>
</a>";

$objHead = new App\Core\genInterfaceTitle($dataHead, 'card', $contHead, $btnStat . $btnAcc . $btnNew, NULL, 'bg-dark text-light', 'h2');
?>
<!-- NAV CONS -->
<?php $objHead->render(); ?>
<!-- NAV PAY -->


<nav class="navbar navbar-expand-lg bg-primary bg-opacity-10 card mb-2 p-2">
	<div class="container-fluid">
		<a class="navbar-brand d-md-block d-lg-none" href="#"><small class="text-muted">Información consulta</small></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<div>
				<fieldset class="row row-cols-lg-auto g-3 align-items-center">
					<div class="col-12">
						<label class="visually-hidden" for="con_typ">Origen Paciente</label>
						<div class="input-group">
							<div class="input-group-text">Origen Paciente</div>
							<?php $paramsTC[] = array(
								array("cond" => "AND", "field" => "typ_ref", "comp" => "=", "val" => 'TIPCON'),
								array("cond" => "AND", "field" => "typ_stat", "comp" => '=', "val" => 1)
							);
							$RStc = $db->detRowGSelNP('db_types', 'typ_cod', 'typ_val', $paramsTC, TRUE, 'typ_val', 'ASC');
							echo $db->genSelect($RStc, 'con_typ', $dCon['con_typ'] ?? null, 'form-control mr-sm-2 setDB', ' data-rel="con" data-id="' . $idsCon . '"') ?>
						</div>
					</div>
					<div class="col-12">
						<label class="visually-hidden" for="typ_cod">Tipo Visita</label>
						<div class="input-group">
							<div class="input-group-text">Tipo Visita</div>
							<?php $paramsTV[] = array(
								array("cond" => "AND", "field" => "typ_ref", "comp" => "=", "val" => 'TIPVIS'),
								array("cond" => "AND", "field" => "typ_stat", "comp" => '=', "val" => 1)
							);
							$RStv = $db->detRowGSelNP('db_types', 'typ_cod', 'typ_val', $paramsTV, TRUE, 'typ_val', 'ASC');
							//var_dump($RStv);
							echo $db->genSelect($RStv, 'con_typvis', $dCon['con_typvis'] ?? null, 'form-control mr-sm-2 setDB', ' data-rel="con" data-id="' . $idsCon . '"') ?>
						</div>
					</div>
					<div class="col-12">
						<label class="visually-hidden" for="con_val">Valor</label>
						<div class="input-group">
							<div class="input-group-text">$</div>
							<input name="con_val" id="con_val" type="text" value="<?php echo $dCon['con_val'] ?? null ?>" class="form-control mr-sm-2 setDB" data-rel="con" data-id="<?php echo $idsCon ?>" placeholder="Valor" />
						</div>
					</div>
					<div class="col-12">
						<label class="visually-hidden" for="tip_pag">Forma Pago</label>
						<div class="input-group">
							<div class="input-group-text">Forma Pago</div>
							<?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'TIPPAG'), 'tip_pag', $dCon['tip_pag'] ?? null, 'form-control mr-sm-2 setDB', 'data-rel="con" data-id="' . $idsCon . '"'); ?>
						</div>
					</div>

				</fieldset>
			</div>

		</div>
	</div>
</nav>