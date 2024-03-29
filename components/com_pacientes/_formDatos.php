<div class="row">
	<div class="col-sm-6">
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_lugp">Procedencia</label>
			<div class="col-md-8">
				<input name="pac_lugp" id="pac_lugp" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_lugp'] ?? null ?>" class="form-control setDB" placeholder="Lugar de Procedencia" />
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_lugr">Residencia</label>
			<div class="col-md-8">
				<input name="pac_lugr" id="pac_lugr" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_lugr'] ?? null ?>" class="form-control setDB" placeholder="Lugar de Residencia" />
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_dir">Dirección</label>
			<div class="col-md-8">
				<input name="pac_dir" id="pac_dir" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_dir'] ?? null ?>" class="form-control setDB" placeholder="Dirección" />
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_sect">Sector</label>
			<div class="col-md-8">
				<?php echo $db->genSelectA($mTipo->getSelTipRef("SECTOR"), 'pac_sect', $dPac['pac_sect'] ?? null, ' form-control input-sm setDB', 'data-id="' . $ids . '" data-rel="pac"', NULL, true, 0) ?>
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_tel1">Telefono 1</label>
			<div class="col-md-8">
				<input name="pac_tel1" id="pac_tel1" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_tel1'] ?? null ?>" class="form-control setDB" />
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_tel2">Telefono 2</label>
			<div class="col-md-8">
				<input name="pac_tel2" id="pac_tel2" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_tel2'] ?? null ?>" class="form-control setDB" />
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_email">E-Mail</label>
			<div class="col-md-8">
				<input name="pac_email" id="pac_email" data-id="<?php echo $ids ?>" data-rel="pac" type="email" placeholder="nombre@mail.com" value="<?php echo $dPac['pac_email'] ?? null ?>" class="form-control setDB" />
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_ins">Instrucción</label>
			<div class="col-md-8">
				<?php echo $db->genSelectA($mTipo->getSelTipRef("INST"), 'pac_ins', $dPac['pac_ins'] ?? null, ' form-control input-sm setDB', 'data-id="' . $ids . '" data-rel="pac"') ?>
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_pro">Profesión</label>
			<div class="col-md-8">
				<input name="pac_pro" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_pro'] ?? null ?>" class="form-control setDB" />
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_emp">Empresa</label>
			<div class="col-md-8">
				<?php echo $db->genSelectA($mTipo->getSelTipRef("EMPTRB"), 'pac_emp', $dPac['pac_emp'] ?? null, ' form-control input-sm setDB', 'data-id="' . $ids . '" data-rel="pac"') ?>
			</div>
		</div>
		<div class="row mb-2">
			<label class="col-md-4 col-form-label" for="pac_ocu">Ocupación</label>
			<div class="col-md-8">
				<input name="pac_ocu" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_ocu'] ?? null ?>" class="form-control setDB" />
			</div>
		</div>
	</div>
	<!--COL-->
	<div class="col-sm-6">
		<div class="row mb-3">
			<label class="col-md-5 col-form-label" for="pac_nompar">Nombre Contacto</label>
			<div class="col-md-7">
				<input name="pac_nompar" id="pac_nompar" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_nompar'] ?? null ?>" class="form-control setDB" />
			</div>
		</div>
		<div class="row mb-3">
			<label class="col-md-5 col-form-label" for="pac_telpar">Teléfono Contacto</label>
			<div class="col-md-7">
				<input name="pac_telpar" id="pac_telpar" data-id="<?php echo $ids ?>" data-rel="pac" type="text" value="<?php echo $dPac['pac_telpar'] ?? null ?>" class="form-control setDB" />
			</div>
		</div>
		<div class="row mb-3">
			<label class="col-md-5 col-form-label" for="pac_tipsanpar">Tipo Sangre</label>
			<div class="col-md-7">
				<?php echo $db->genSelectA($mTipo->getSelTipRef("TIPSAN"), 'pac_tipsanpar', $dPac['pac_tipsanpar'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$ids'") ?>
			</div>
		</div>
		<hr>
		<div class="row mb-3">
			<label class="col-md-5 col-form-label" for="publi">Publicidad</label>
			<div class="col-md-7">
				<?php echo $db->genSelectA($mTipo->getSelTipRef("PUBLI"), 'publi', $dPac['publi'] ?? null, 'form-control setDB', 'data-id="' . $ids . '" data-rel="pac"', NULL, 'Todos') ?>
			</div>
		</div>
		<div class="row mb-3">
			<label class="col-md-5 col-form-label" for="pac_obs">Observaciones</label>
			<div class="col-md-7">
				<textarea name="pac_obs" rows="9" class="form-control setDB" data-id="<?php echo $ids ?>" data-rel="pac" id="pac_obs"><?php echo $dPac['pac_obs'] ?? null ?></textarea>
			</div>
		</div>
	</div>
</div>