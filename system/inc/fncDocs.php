<?php
function genDocDataChange($field, $dat)
{
	global $RAIZi;
	switch ($field) {
		case "{fec}":
			$res = $GLOBALS['sdateFull'];
			break;
		case "{fecm}":
			$res = $GLOBALS['sdate'];
			break;
		case "{pac_nom}":
			$res = $dat['pac']['pac_nom'];
			break;
		case "{pac_ape}":
			$res = $dat['pac']['pac_ape'];
			break;
		case "{pac_ced}":
			$res = $dat['pac']['pac_ced'];
			break;
		case "{pac_edad}":
			$res = edad($dat['pac']['pac_fec'], ' años');
			break;
		case "{con_diag}":
			$res = $dat['con']['diag'];
			break;
		case "{con_diagm}":
			$res = $dat['con']['diagm'];
			break;
		case "{usu_nomape}":
			$res = $dat['emp']['emp_nom'] . ' ' . $dat['emp']['emp_ape'];
			break;
		case "{usu_esp}":
			$res = $dat['emp']['emp_esp'];
			break;
		case "{usu_mail}":
			$res = $dat['emp']['emp_mail'];
			break;
		case "{pac_cod}":
			$res = $dat['pac']['pac_cod'];
			break;
		case "{img-sello}":
			$res = '<img src="' . $RAIZi . 'struct/selloA-02.jpg" alt="" style="width: 180px">'; //$dat['pac']['pac_cod'];
			break;
		default:
			$res = null;
			break;
	}
	return $res;
}
function genDoc($id_df, $dat = NULL)
{
	global $conn;
	$resDiag = null;
	$resDiagM = null;
	$contDE = null;
	//var_dump($_SESSION['dU']);
	$dE = detRow('db_empleados', 'emp_cod', $_SESSION['dU']['ID']);
	$dat['emp'] = $dE;
	if ($dat['con']['con_num']) {
		$qLD = sprintf(
			'SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 5',
			SSQL($dat['con']['con_num'], 'int')
		);
		$RSld = mysqli_query(conn, $qLD);
		$dRSld = mysqli_fetch_assoc($RSld);
		$tRSld = mysqli_num_rows($RSld);
		if ($tRSld > 0) {
			do {
				if ($dRSld['id_diag'] > 1) {
					$dDiag = detRow('db_diagnosticos', 'id_diag', $dRSld['id_diag']);
					$dDiag_cod = ' (' . $dDiag['codigo'] . ') ';
					$dDiag_nom = $dDiag['nombre'];
				} else {
					$dDiag_cod = NULL;
					$dDiag_nom = $dRSld['obs'];
				}
				if ($contDE < 1) $resDiagM = $dDiag_nom . $dDiag_cod;
				$resDiag .= ' <span>' . $dDiag_nom . $dDiag_cod . '</span>';
				$contDE++;
				if (($contDE > 0) && ($contDE < $tRSld)) $resDiag .= ',';
			} while ($dRSld = mysqli_fetch_assoc($RSld));
		}
	}
	$dat['con']['diag'] = $resDiag;
	$dat['con']['diagm'] = $resDiagM;

	//GENERACION Y CARGA DE DATOS EN FORMATO
	$dDF = detRow('db_documentos_formato', 'id_df', $id_df);
	$format = $dDF['formato'];
	preg_match_all('/\{(.*?)\}/', $format, $res);
	$vecO = $res[0];
	foreach ($res[0] as $valor) {
		$resField = genDocDataChange($valor, $dat);
		//echo 'field sale. '.$resField.'<br>';
		$vecP[$valor] = $valor;
		$vecN[$valor] = $resField;
	}
	$formatN = str_replace($vecP, $vecN, $format);
	//$docR['id']=$id;
	//$docR['sel']=$sel;
	$docR['format'] = $formatN;
	return $docR;
} //genDoc

function genDoc_old($sel, $dat = NULL)
{
	$resDiag = null;
	$contDE = null;
	$dCon = detRow('db_consultas', 'con_num', $dat["idc"]);
	if ($dCon) {
		$qLD = sprintf(
			'SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
			SSQL($dCon['con_num'], 'int')
		);
		$RSld = mysqli_query(conn, $qLD);
		$dRSld = mysqli_fetch_assoc($RSld);
		$tRSld = mysqli_num_rows($RSld);

		if ($tRSld > 0) {
			do {
				if ($dRSld["id_diag"] > 1) {
					$dDiag = detRow('db_diagnosticos', 'id_diag', $dRSld["id_diag"]);
					$dDiag_cod = ' (' . $dDiag["codigo"] . ') ';
					$dDiag_nom = $dDiag["nombre"];
				} else {
					$dDiag_cod = NULL;
					$dDiag_nom = $dRSld["obs"];
				}
				$resDiag .= ' <span>' . $dDiag_nom . $dDiag_cod . '</span>';
				if ($contDE > 0) $resDiag .= $contDE . ',';
				$contDE++;
			} while ($dRSld = mysqli_fetch_assoc($RSld));
		}
	}
	switch ($sel) {
		case 'CERTIFICADO SALUD / PERMISO':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, por presentar cuadro compatible con %s se recomienda tratamiento sintomático mas reposo absoluto por </p>
		<br>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO COVID SALUD / PERMISO':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, por presentar cuadro compatible con %s se recomienda tratamiento sintomático mas reposo absoluto mas aislamiento por </p>
		<p>Por condiciones generales del paciente puede realizar teletrabajo.</p>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO BUEN ESTADO DE SALUD':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, con diagnóstico:  %s.</p>
		<p>Luego del exámen clínica y exámenes complementarios correspondientes, no presenta ningun tipo de enfermedad infecto-contagiosa y se encuentra en buen estado de salud.</p>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO SALUD / GENERAL':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, luego de realizado el examen médico clínico correspondiente, el paciente se encuentra en perfecto estado de salud y no presenta ningún tipo de enfermedad infecto contagiosa. </p>
		<br>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], '')
			);
			break;
		case 'CERTIFICADO ASISTENCIA':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica en el Hospital del Rio el día de hoy %s de a , por presentar cuadro compatible con %s. </p>
		<br>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($dat['fec'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO IESS MENOR DE EDAD':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, por presentar cuadro compatible con %s se recomienda tratamiento sintomático mas reposo absoluto por . </p>
		<br>
		<p>Por ser el paciente un niño(a) requirió la compañia de su representante .</p>
		<br>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO IESS TERCERA EDAD':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, por presentar cuadro compatible con %s se recomienda tratamiento sintomático mas reposo absoluto por . </p>
		<br>
		<p>Por ser el paciente de la tercera edad requirió la compañia de su representante .</p>
		<br>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO VIAJE CON OXIGENO':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, por presentar cuadro compatible con %s. </p>
		<br>
		<p>Por ser el paciente oxígeno dependiente necesita viajar con oxígeno, </p>
		<br>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO HOSPITALIZACION':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, fue ingresado al Hospital Universitario del Rio, el dia de hoy %s, por presentar cuadro compatible con %s, será dado de alta de acuerdo a evolución clínica.</p>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($dat['fec'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO ALTA HOSPITALIZACION':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, estuvo hospitalizado en el Hospital Universitario del Rio, desde  hasta, requiere reposo absoluto</p>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($dat['fec'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO IMPEDIMENTO VIAJE':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, por presentar cuadro compatible con %s se recomienda tratamiento sintomático y controles periódicos, razon por la cual no puede viajar por via aerea ni terrestre.</p>
		<br>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO NO DEPORTES':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, acudió para consulta médica el día de hoy, por presentar cuadro compatible con %s se recomienda tratamiento sintomático mas reposo absoluto por </p>
		<p>El paciente debe evitar bajas y cambios bruscos de temperatura y no puede realizar actividad física forzada, hasta nuevo control médico.</p>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], ''),
				SSQL($resDiag, '')
			);
			break;
		case 'CERTIFICADO REQUIERE HOSPITALIZACION':
			$id = 0;
			$format = sprintf(
				'<div style="font-size:14px; text-align: justify">
		<p style="text-align: right;">Cuenca, %s.</p>
		<br/><br/>
		<p>Yo, DR. JOSE RICARDO ORDOÑEZ VINTIMILLA, Médico Cirujano Especialista en Torax y Enfermedades Broncopulmonares, con cédula de Ciudadanía No. 0101387926 y No. Registro Ministerio de Salud Pública , Libro 8 Folio 96, Número  285, 17 de Septiembre de 1985; por medio de la presente, </p>
		<p style="font-size: 30px; text-align: center;">CERTIFICO</p>
		<p>Que %s, con C.C. %s, H.C: %s, Por mal estado general, el paciente requiere ser hospitalizado para tratamiento y para realizarse exámenes complementarios.</p>
		<p>Es todo cuanto puedo certificar en honor a la verdad y autorizo al portador del presente documento a darle el uso que más convenga a sus intereses.</p>
		<br/><br/>
		<div style="text-align:center">
		<p>Atentamente</p>
		<p><img src="{RAIZ}assets/images/struct/selloA-02.jpg" alt="" style="width: 180px"></p>
		<p style="text-align: center;">Dr. J. Ricardo Ordoñez V.</p>
		</div>
		</div>',
				SSQL($dat['fec'], ''),
				SSQL($dat['nom'], ''),
				SSQL($dat['doc'], ''),
				SSQL($dCon['pac_cod'], '')
			);
			break;
		default:
			$id = NULL;
			$format = NULL;
	}
	$docR['id'] = $id;
	$docR['sel'] = $sel;
	$docR['format'] = $format;
	return $docR;
}//genDoc
