<?php

function genSelectG($nom, $RS_datos, $sel = NULL, $class = NULL, $opt = NULL)
{
	//$nom. name selselector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales	

	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);

	if (!$nom) $nom = "select";
	echo '<select name="' . $nom . '" id="' . $nom . '" class="' . $class . '" ' . $opt . '>';
	echo '<option value=""';
	if (isset($sel) && !(strcmp(-1, $sel))) {
		echo "selected=\"selected\"";
	} ?>	
	<?php echo '>- Seleccione -</option>';
	if ($totalRows_RS_datos > 0) {
		$grpSel = NULL;
		$banG = false;
		do {
			$grpAct = $row_RS_datos['sGRUP'];
			if ($grpSel != $grpAct) {
				if ($banG == true) echo '</optgroup>';
				echo '<optgroup label="' . $row_RS_datos['sGRUP'] . '">';
				$grpSel = $grpAct;
				$banG = true;
			}
			echo '<option value="' . $row_RS_datos['sID'] . '"';
			if (isset($sel) && !(strcmp($row_RS_datos['sID'], $sel))) {
				echo "selected=\"selected\"";
			} ?>	
			<?php echo '>' . $row_RS_datos['sVAL'] . '</option>';
		} while ($row_RS_datos = mysqli_fetch_assoc($RS_datos));
		if ($banG == true) echo '</optgroup>';
	}
	$rows = mysqli_num_rows($RS_datos);
	if ($rows > 0) {
		mysqli_data_seek($RS_datos, 0);
		$row_RSe = mysqli_fetch_assoc($RS_datos);
	}
	echo '</select>';
	mysqli_free_result($RS_datos);
}



function genSelect($nom, $RS, $sel = NULL, $class = NULL, $opt = NULL, $id = NULL, $placeHolder = NULL, $showIni = TRUE, $valIni = NULL, $nomIni = "Select")
{
	//Version 3.3.1
	/* PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
	*/
	$grpSel = null;
	$banG = null;
	if ($RS) {
		$dRS = mysqli_fetch_assoc($RS);
		$tRS = mysqli_num_rows($RS);

		if (!isset($id)) $id = $nom;
		if (!$nom) $nom = "select";
		echo '<select name="' . $nom . '" id="' . $id . '" class="' . $class . '" data-placeholder="' . $placeHolder . '" ' . $opt . '>';

		if ($showIni == TRUE) {
			echo '<option value="' . $valIni . '"';
			if (!$sel) {
				echo "selected=\"selected\"";
			}
			echo '>' . $nomIni . '</option>';
		}

		if ($tRS > 0) {
			do {
				$grpAct = $dRS['sGRUP'];
				if (($grpSel != $grpAct) && ($grpAct)) {
					if ($banG == true) echo '</optgroup>';
					echo '<optgroup label="' . $dRS['sGRUP'] . '">';
					$grpSel = $grpAct;
					$banG = true;
				}
				echo '<option value="' . $dRS['sID'] . '"';
				if (is_array($sel)) {
					if (in_array($dRS['sID'], $sel)) {
						echo 'selected="selected"';
					}
				} else {
					if (isset($sel) && !(strcmp($dRS['sID'], $sel))) {
						echo 'selected="selected"';
					}
				}
			?>
		<?php echo '>' . $dRS['sVAL'] . '</option>';
			} while ($dRS = mysqli_fetch_assoc($RS));
			if ($banG == true) echo '</optgroup>';
			$rows = mysqli_num_rows($RS);
			if ($rows > 0) {
				mysqli_data_seek($RS, 0);
				$dRSe = mysqli_fetch_assoc($RS);
			}
		}
		echo '</select>';

		mysqli_free_result($RS);
	} else {
		echo '<span class="label label-danger">Error genSelect : ' . $nom . '</span>';
	}
}

function clsRO($val)
{
	$valFin = eregi_replace("[\n|\r|\n\r]", " ", $val);
	return $valFin;
}
function datefRO($val)
{
	$newDate = date("Y-m-d", strtotime($val));
	return ($newDate);
}


function calcIMCm($IMC = NULL, $pesoKG = NULL, $talla = NULL)
{

	global $RAIZi;
	$infIMC = null;
	$tallacm = $talla / 100;
	if ((!$IMC) || ($IMC == NULL) || ($IMC == 0)) {
		if (($tallacm > 0) && ($pesoKG > 0)) {
			$IMC = $pesoKG / ($tallacm * $tallacm);
		}
	}
	if ($IMC) {
		$retIMC['val'] = number_format($IMC, 2);
		if ($IMC <= 0) $infIMCb = ' <span class="btn btn-default btn-lg btn-block"> IMC </span> ';
		if (($IMC > 0) && ($IMC < 18)) {
			$infIMCb = '<span class="btn btn-danger btn-lg btn-block">Peso Bajo</span>';
		}
		if (($IMC >= 18) && ($IMC < 25)) {
			$infIMCb = '<span class="btn btn-info btn-lg btn-block">Normal</span>';
		}
		if (($IMC >= 25) && ($IMC < 30)) {
			$infIMCb = '<span class="btn btn-success btn-lg btn-block">Sobrepeso</span>';
		}
		if (($IMC >= 30) && ($IMC < 35)) {
			$infIMCb = '<span class="btn btn-warning btn-lg btn-block">Obesidad I</span>';
		}
		if (($IMC >= 35) && ($IMC < 40)) {
			$infIMCb = '<span class="btn btn-warning btn-lg btn-block">Obesidad II</span>';
		}
		if ($IMC >= 40) {
			$infIMCb = '<span class="btn btn-danger btn-block btn-lg"> Obesidad III</span>';
		}

		$infIMC .= '<a href="' . $RAIZi . 'struct/img-IMC-02.jpg" class="fancybox">' . $infIMCb . '</a>';
		$infIMC .= "
		<table class='table table-bordered cero' style='font-size:120%'>
		<tr><th>I.M.C.</th><th>$retIMC[val]</th><tr>
		<tr><td>$pesoKG kg.</td><td>$talla cm.</td><tr>
		</table>";


		$retIMC['inf'] = $infIMC;


		$retIMC['log'] = 'calculado';
	} else {
		$retIMC['log'] = 'no params';
	}
	return $retIMC;
}

function calcPAm_old($pa)
{
	global $RAIZi;
	$infPA = null;
	if ($pa) {
		$paA = explode("/", $pa);
		$paS = $paA[0];
		$paD = $paA[1];

		if (($paS < 120) && ($paD < 80)) {
			$infPAb = '<span class="btn btn-success btn-lg btn-block">NORMAL</span>';
		}
		if ((($paS >= 120) && ($paS <= 129)) && ($paD < 80)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ELEVADA</span>';
		}
		if ((($paS >= 130) || ($paS <= 139)) && ($paD >= 80) && ($paD <= 89)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ALTA NIVEL 1</span>';
		}
		if (($paS >= 140) || ($paD >= 90)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ALTA NIVEL 2</span>';
		}
		if (($paS >= 180) || ($paD >= 120)) {
			$infPAb = '<span class="btn btn-danger btn-lg btn-block">CRISIS HIPERTENSION</span>';
		}

		$infPA .= '<a href="' . $RAIZi . 'struct/img-PA-01.jpg" class="fancybox">' . $infPAb . '</a>';
		$infPA .= "
		<table class='table table-bordered cero' style='font-size:120%'>
		<tr><th>Sistolica $paS</th><th>Diastolica $paD</th><tr>
		</table>";

		$ret['val'] = $pa;
		$ret['inf'] = $infPA;


		$ret['log'] = 'calculado';
	} else {
		$ret['log'] = 'no params';
	}
	return $ret;
}

function calcPAm($paS, $paD)
{
	global $RAIZi;
	$infPA = null;
	if ($paS && $paD) {
		if (($paS < 120) && ($paD < 80)) {
			$infPAb = '<span class="btn btn-success btn-lg btn-block">NORMAL</span>';
		}
		if ((($paS >= 120) && ($paS <= 129)) && ($paD < 80)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ELEVADA</span>';
		}
		if ((($paS >= 130) || ($paS <= 139)) && ($paD >= 80) && ($paD <= 89)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ALTA NIVEL 1</span>';
		}
		if (($paS >= 140) || ($paD >= 90)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ALTA NIVEL 2</span>';
		}
		if (($paS >= 180) || ($paD >= 120)) {
			$infPAb = '<span class="btn btn-danger btn-lg btn-block">CRISIS HIPERTENSION</span>';
		}

		$infPA .= '<a href="' . $RAIZi . 'struct/img-PA-01.jpg" class="fancybox">' . $infPAb . '</a>';
		$infPA .= "
		<table class='table table-bordered cero' style='font-size:120%'>
		<tr><th>Sistolica $paS</th><th>Diastolica $paD</th><tr>
		</table>";

		$ret['val'] = $paS . '/' . $paD;
		$ret['inf'] = $infPA;


		$ret['log'] = 'calculado';
	} else {
		$ret['log'] = 'no params';
	}
	return $ret;
}

function calcIMC($IMC = NULL, $pesoKG = NULL, $talla = NULL)
{
	$val = null;
	$IMC = null;

	$talla = (int)$talla / 100;
	if ((!$IMC) || ($IMC == NULL) || ($IMC == 0)) {
		if (($talla > 0) && ($pesoKG > 0)) {
			$valTalla = $talla * $talla;
			$IMC = (double)$pesoKG / (double)$valTalla;
		}
	}

	if ($IMC <= 0) $infIMC = ' <span class="label label-default"> IMC </span> ';
	if (($IMC > 0) && ($IMC < 18)) {
		$infIMC = '<span class="label label-danger">Peso Bajo</span>';
	}
	if (($IMC >= 18) && ($IMC < 25)) {
		$infIMC = '<span class="label label-info">Normal</span>';
	}
	if (($IMC >= 25) && ($IMC < 30)) {
		$infIMC = '<span class="label label-success">Sobrepeso</span>';
	}
	if (($IMC >= 30) && ($IMC < 35)) {
		$infIMC = '<span class="label label-warning">Obesidad I</span>';
	}
	if (($IMC >= 35) && ($IMC < 40)) {
		$infIMC = '<span class="label label-warning">Obesidad II</span>';
	}
	if ($IMC >= 40) {
		$infIMC = '<span class="label label-danger"> Obesidad III</span>';
	}
	if (isset($IMC)) $val = number_format($IMC, 2);
	$ret['val'] = $val;
	$ret['inf'] = $infIMC;

	return $ret;
}

function genDataListNum($id, $min, $max, $step)
{
	$ret = null;
	$retData = null;
	if ($id) {
		if ($min < $max) {
			if ($step > 0) {
				$ret = '<datalist id="' . $id . '">';
				$numA = $min;
				do {
					$numA = number_format($numA, 2, '.', ',');
					$retData .= '<option value="' . $numA . '">';
					$numA += $step;
				} while ($numA <= $max);
				$ret .= $retData . '</datalist>';
			} else {
				$ret = '<span>Minium step number is 1</span>';
			}
		} else {
			$ret = '<span>Incorrect defined min and max</span>';
		}
	} else {
		$ret = '<span>No ID for datalist</span>';
	}
	return $ret;
	//end function                     
}

function generarselectG($nom, $RS_datos, $sel = NULL, $class = NULL, $opt = NULL)
{
	//$nom. name selselector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales	

	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);

	if (!$nom) $nom = "select";
	echo '<select name="' . $nom . '" id="' . $nom . '" class="' . $class . '" ' . $opt . '>';
	echo '<option value=""';
	if (isset($sel) && !(strcmp(-1, $sel))) {
		echo "selected=\"selected\"";
	} ?>	
	<?php echo '>- Seleccione -</option>';
	if ($totalRows_RS_datos > 0) {
		$grpSel = NULL;
		$banG = false;
		do {
			$grpAct = $row_RS_datos['sGRUP'];
			if ($grpSel != $grpAct) {
				if ($banG == true) echo '</optgroup>';
				echo '<optgroup label="' . $row_RS_datos['sGRUP'] . '">';
				$grpSel = $grpAct;
				$banG = true;
			}
			echo '<option value="' . $row_RS_datos['sID'] . '"';
			if (isset($sel) && !(strcmp($row_RS_datos['sID'], $sel))) {
				echo "selected=\"selected\"";
			} ?>	
			<?php echo '>' . $row_RS_datos['sVAL'] . '</option>';
		} while ($row_RS_datos = mysqli_fetch_assoc($RS_datos));
		if ($banG == true) echo '</optgroup>';
	}
	$rows = mysqli_num_rows($RS_datos);
	if ($rows > 0) {
		mysqli_data_seek($RS_datos, 0);
		$row_RSe = mysqli_fetch_assoc($RS_datos);
	}
	echo '</select>';
	mysqli_free_result($RS_datos);
}


//FUNCTION TO GENERATE SELECT (FORM html)
function generarselect($nom, $RS_datos, $sel = NULL, $class = NULL, $opt = NULL, $id = NULL, $placeHolder = NULL, $showIni = TRUE)
{
	//Version 3.0 (Multiple con soporte choses, selected multiple)
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	$grpSel = null;
	$banG = null;

	if ($RS_datos) {
		$row_RS_datos = mysqli_fetch_assoc($RS_datos);
		$totalRows_RS_datos = mysqli_num_rows($RS_datos);


		if (!isset($id)) $id = $nom;
		if (!$nom) $nom = "select";
		echo '<select name="' . $nom . '" id="' . $id . '" class="' . $class . '" data-placeholder="' . $placeHolder . '" ' . $opt . '>';

		if ($showIni == TRUE) {
			echo '<option value=""';
			if (!$sel) {
				echo "selected=\"selected\"";
			}
			echo '>- Seleccione -</option>';
		}

		if ($totalRows_RS_datos > 0) {
			do {
				$grpAct = $row_RS_datos['sGRUP'];
				if (($grpSel != $grpAct) && ($grpAct)) {
					if ($banG == true) echo '</optgroup>';
					echo '<optgroup label="' . $row_RS_datos['sGRUP'] . '">';
					$grpSel = $grpAct;
					$banG = true;
				}
				echo '<option value="' . $row_RS_datos['sID'] . '"';
				if (is_array($sel)) {
					if (in_array($row_RS_datos['sID'], $sel)) {
						echo 'selected="selected"';
					}
				} else {
					if (isset($sel) && !(strcmp($row_RS_datos['sID'], $sel))) {
						echo 'selected="selected"';
					}
				}
			?>
		<?php echo '>' . $row_RS_datos['sVAL'] . '</option>';
			} while ($row_RS_datos = mysqli_fetch_assoc($RS_datos));
			if ($banG == true) echo '</optgroup>';
			$rows = mysqli_num_rows($RS_datos);
			if ($rows > 0) {
				mysqli_data_seek($RS_datos, 0);
				$row_RSe = mysqli_fetch_assoc($RS_datos);
			}
		}
		echo '</select>';

		mysqli_free_result($RS_datos);
	} else {
		echo '<span class="label label-danger">Error generarSelect : ' . $nom . '</span>';
	}
}

		?>